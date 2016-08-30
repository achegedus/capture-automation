<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Client extends Model
{
    //
    protected $table = 'clients';
    protected $primaryKey = 'clientID';
    protected $dateFormat = 'Y-m-d';
    protected $dates = ['ECMA_start', 'ECMA_renew'];
    
    public $timestamps = false;
    
    
    // Relationships
    
    /**
     * client files for this client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientFiles()
    {
        return $this->hasMany('App\Models\ClientFile', 'clientID', 'clientID');
    }
    
    
    /**
     * kickout files for this client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partnerFiles()
    {
        return $this->hasMany('App\Models\PartnerFile', 'clientID', 'clientID');
    }
    
    public function catalogServices()
    {
        return $this->hasOne('App\Models\CatalogService', 'catalogServiceID', 'catalogServiceID');
    }
    
    /**
     * ECMA Percentage as of today
     *
     * @return string
     */
    public function ECMAPercentage()
    {
        if (!$this->ECMA_start || !$this->ECMA_renew) {
            return 0;
        }
        
        $ecmaDays = $this->ECMA_start->diffInDays($this->ECMA_renew);
        $ecmaToDate = $this->ECMA_start->diffInDays(new Carbon());
        
        return number_format($ecmaToDate / $ecmaDays * 100, 0) . "%";
    }
    
    /**
     *
     *
     * @return mixed
     */
    public function monthly_detail()
    {
        $query = "SELECT Invoicing. *
        FROM
        (
        SELECT #DISTINCT
             YEAR(pf.processDate) 'year'
            ,MONTH(pf.processDate) 'month'
            ,c.clientName 'client'
            ,bt.billingTypeName 'transactionType'
            ,SUM(pb.count) 'total'
            ,bf.fee 'unitCost'
            ,SUM(pb.count) * bf.fee 'subtotal'
        FROM partnerBilling pb
        JOIN partnerFiles pf ON pb.partnerFileID = pf.partnerFileID
        JOIN clients c ON pf.clientID = c.clientID
        JOIN clientFiles cf ON pf.clientFileID = cf.clientFileID
        JOIN billingTypes bt ON pb.billingTypeID = bt.billingTypeID
        LEFT OUTER JOIN billingFees bf ON pb.billingTypeID = bf.billingTypeID
            AND bf.clientID = c.clientID
        WHERE pb.count <> 0 AND pf.processed = 1
            AND ((DATE(pf.processDate) >= DATE(c.ECMA_start) AND DATE(pf.processDate) < (c.ECMA_renew)) or c.ECMA_start is NULL)
            AND c.clientID = $this->clientID
        GROUP BY c.clientName, bt.billingTypeName, bf.fee, YEAR(pf.processDate), MONTH(pf.processDate)
        ) Invoicing
        ORDER BY Year desc, Month desc, Client, 'Transaction Type';";
        
        $result = DB::select($query);
        
        return $result;
    }
    
    
    /**
     * @return mixed
     */
    public function batch_detail()
    {
        $query = "
            SELECT DISTINCT
    cf.fileName
    ,pf.batchCode
	,cf.uploadTimestamp
	,pf.processDate
    ,bt.billingTypeName 'transactionType'
    ,pb.count 'total'
FROM partnerBilling pb
JOIN partnerFiles pf ON pb.partnerFileID = pf.partnerFileID
JOIN clients c ON pf.clientID = c.clientID
JOIN clientFiles cf ON pf.clientFileID = cf.clientFileID
JOIN billingTypes bt ON pb.billingTypeID = bt.billingTypeID
#LEFT OUTER JOIN billingFees bf ON pb.billingTypeID = bf.billingTypeID
	#AND bf.clientID = c.clientID
WHERE pb.count <> 0 AND pf.processed = 1
	AND ((DATE(pf.processDate) >= DATE(c.ECMA_start) AND DATE(pf.processDate) < (c.ECMA_renew)) or c.ECMA_start is NULL)
    AND c.clientID = $this->clientID
ORDER BY processDate DESC;";
        
        $result = DB::select($query);
        
        return $result;
    }
    
    
    /**
     * @return mixed
     */
    public function transaction_data()
    {
        $query = "
            SELECT clientName,
                ECMA_start,
                clientEmail,
                usage_alert_percent,
                ECMA_renew AS 'renewal_ecmaDate',
                TIMESTAMPDIFF(DAY, NOW(),
                ECMA_renew) 'days_ecmaRenewal',
                proposedVolume_livebills,
                TIMESTAMPDIFF(DAY, NOW(), ECMA_renew) 'days_ecmaRenewal',
                SUM(CASE WHEN billingTypeName IN ('FTP Image File', 'Mail Redirect', 'Web Download', 'Electronic Transfer', 'EDI') THEN Count ELSE 0 END) AS 'actual_livebills',
                SUM(CASE WHEN billingTypeName IN ('FTP Image File', 'Mail Redirect', 'Web Download', 'Electronic Transfer', 'EDI') THEN Count ELSE 0 END) / proposedVolume_livebills AS 'percentage_livebills',
                proposedVolume_livebills - SUM(CASE WHEN billingTypeName IN ('FTP Image File', 'Mail Redirect', 'Web Download', 'Electronic Transfer', 'EDI') THEN Count ELSE 0 END) 'remaining_livebills',
                proposedVolume_histbills,
                SUM(CASE WHEN billingTypeName IN ('FTP Image File - History', 'Web Download - History', 'Mail Redirect - History', 'Electronic Transfer - History') THEN Count ELSE 0 END) AS 'actual_histbills',
                SUM(CASE WHEN billingTypeName IN ('FTP Image File - History', 'Web Download - History', 'Mail Redirect - History', 'Electronic Transfer - History') THEN Count ELSE 0 END) / proposedVolume_histbills 'percentage_histbills',
                proposedVolume_histbills - SUM(CASE WHEN billingTypeName IN ('FTP Image File - History', 'Web Download - History', 'Mail Redirect - History', 'Electronic Transfer - History') THEN Count ELSE 0 END) 'remaining_histbills',
                proposedVolume_accts,
                SUM(CASE WHEN billingTypeName IN ('New Accounts') THEN Count ELSE 0 END) AS 'actual_newAccounts',
                SUM(CASE WHEN billingTypeName IN ('New Accounts') THEN Count ELSE 0 END) / proposedVolume_accts 'percentage_newAccounts',
                proposedVolume_accts - SUM(CASE WHEN billingTypeName IN ('New Accounts') THEN Count ELSE 0 END) 'remaining_newAccounts'
            FROM
            (
            SELECT DISTINCT
                c.clientName,
                c.usage_alert_percent,
                c.clientEmail,
                c.transactions_alert,
                c.ECMA_start,
                c.ECMA_renew,
                c.proposedVolume_accts,
                c.proposedVolume_livebills,
                c.proposedVolume_histbills,
                bt.billingTypeName,
                SUM(pb.count) 'Count'
            FROM clients c
            LEFT OUTER JOIN partnerFiles pf ON c.clientID = pf.clientID
                AND (DATE(pf.processDate) >= DATE(c.ECMA_start) AND DATE(pf.processDate) < (c.ECMA_renew))
            LEFT OUTER JOIN partnerBilling pb ON pf.partnerFileID = pb.partnerFileID
            LEFT OUTER JOIN billingTypes bt ON pb.billingTypeID = bt.billingTypeID
            #LEFT OUTER JOIN billingFees bf ON pb.billingTypeID = bf.billingTypeID
                            #AND bf.clientID = c.clientID
            WHERE (pb.count <> 0 OR pb.count IS NULL)
                AND c.invoiceSchedule = 'ECMA'
                AND (pf.processed = 1 OR pf.processed IS NULL)
                AND c.clientID = $this->clientID
            GROUP BY c.clientName, bt.billingTypeName
            ) ContractLimits
            GROUP BY clientname
            ORDER BY clientName, billingTypeName;";
        $result = DB::select($query);
        
        if (count($result) == 0) {
            return false;
        }
        
        return $result[0];
    }
    
    
    /**
     * returns URL of bill images
     *
     * @return string
     */
    public function billImageURL()
    {
        if ($this->catalogServiceID == "4") {
            return "https://billimages.energycap.com/images/express/{$this->datasource}/{$this->username}";
        } else if ($this->catalogServiceID == "2") {
            return "https://billimages.energycap.com/images/pro/{$this->datasource}/{$this->username}";
        } else {
            return "https://billimages.energycap.com/images/{$this->datasource}";
        }
    }
    
    
    /**
     * takes clientEmail and returns comma delimited list of non eci addresses
     *
     * @return array
     */
    public function clientEmails()
    {
        //take the list of emails from the ECBC database and find the @energycap.com address's to use in the BCC for any email that is sent
        $splitEmails = explode(",", $this->clientEmail);
        $clientEmails = [];
    
        foreach ($splitEmails as $email) {
            if (!preg_match('/@energycap\.com/i', $email)) {
                $clientEmails[] = $email;
            }
        }
    
        if (count($clientEmails) == 0) {
            return null;
        } else {
            return $clientEmails;
        }
    }
    
    
    /**
     * takes clientEmail and returns comma delimited list of only eci addresses
     *
     * @return array
     */
    public function bccEmails()
    {
        //take the list of emails from the ECBC database and find the @energycap.com address's to use in the BCC for any email that is sent
        $splitEmails = explode(",", $this->clientEmail);
        $bccEmails = [];
    
        foreach ($splitEmails as $email) {
            if (preg_match('/@energycap\.com/i', $email)) {
                $bccEmails[] = $email;
            }
        }
        
        if (count($bccEmails) == 0) {
            return null;
        } else {
            return $bccEmails;
        }
    }
}
