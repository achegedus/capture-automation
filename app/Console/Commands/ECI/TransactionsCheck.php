<?php

namespace App\Console\Commands\ECI;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionsCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecbc:transactions_check';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get all clients
        $clients = Client::all();
        
        // Loop through clients
        foreach ($clients as $client) {
            
            // get transaction data
            if (!$trans = $client->transaction_data()) {
                continue;
            }
            
            $trans->ECMA_start = Carbon::createFromFormat('Y-m-d', $trans->ECMA_start);
            $trans->renewal_ecmaDate = Carbon::createFromFormat('Y-m-d', $trans->renewal_ecmaDate);
            
            // total days in ECMA period
            $ecmaDays = $trans->ECMA_start->diffInDays($trans->renewal_ecmaDate);
            
            // ECMA days to date
            $currentDate = new Carbon();
            $ecmaToDate = $trans->ECMA_start->diffInDays($currentDate);
            $daysPercentUsed = $ecmaToDate / $ecmaDays * 100;
            
            
            // **************** Live Bills ******************* //
            
            // On Pace
            // if the proposedVolume column is NULL it will be skipped
            if ($trans->proposedVolume_livebills >= 0) {
                
                if ($trans->proposedVolume_livebills == 0)
                    $liveTransPercentUsed = 0;
                else
                    $liveTransPercentUsed = $trans->actual_livebills / $trans->proposedVolume_livebills * 100;
                
                // Exceeded Proposed Volume
                if ($trans->actual_livebills > $trans->proposedVolume_livebills) {
                    $liveOutput = array(); // set the empty array for the view
                    $liveOutput['clientName'] = $trans->clientName;
                    $liveOutput['totalContracted'] = $trans->proposedVolume_livebills;
                    $liveOutput['actualUsage'] = $trans->actual_livebills;
                    $liveOutput['type'] = "Live Transactions";
                    $liveOutput['subType'] = "Exceeded";
                    $liveOutput['renewal'] = $trans->renewal_ecmaDate->toFormattedDateString();
                    
                    // send email
                    Mail::send('emails.trans-alert', $liveOutput, function ($m) {
                        $m->from('bills@energycap.com', 'EnergyCAP Bill CAPture');
                        $m->to('bills@energycap.com')->subject("Usage Alert");
                    });
                    
                } else if (($liveTransPercentUsed > 0 ) && (($liveTransPercentUsed - $daysPercentUsed) > $trans->usage_alert_percent)) {
                    $liveOutput = array(); // set the empty array for the view
                    $liveOutput['clientName'] = $trans->clientName;
                    $liveOutput['transUsedPercentage'] = round($liveTransPercentUsed);
                    $liveOutput['daysUsedPercentage'] = round($daysPercentUsed);
                    $liveOutput['type'] = "Live Transactions";
                    $liveOutput['subType'] = "Pace";
                    $liveOutput['renewal'] = $trans->renewal_ecmaDate->toFormattedDateString();
    
                    // send email
                    Mail::send('emails.trans-alert', $liveOutput, function ($m) {
                        $m->from('bills@energycap.com', 'EnergyCAP Bill CAPture');
                        $m->to('bills@energycap.com')->subject("Usage Alert");
                    });
                }
            }
            
    
            // *************** Historical Bills ************** //
    
            // if the proposedVolume column is NULL it will be skipped
            if ($trans->proposedVolume_histbills >= 0) {
        
                // check to see if they used more than 10 transactions over their proposed amount
                if ($trans->actual_histbills > ($trans->proposedVolume_histbills + 10)) {
            
                    $histOutput = array(); // set the empty array for the view
                    $histOutput['clientName'] = $trans->clientName;
                    $histOutput['totalContracted'] = $trans->proposedVolume_histbills;
                    $histOutput['actualUsage'] = $trans->actual_histbills;
                    $histOutput['type'] = "Historical Transactions";
                    $histOutput['renewal'] = $trans->renewal_ecmaDate->toFormattedDateString();
                    
                    // send email
                    Mail::send('emails.trans-alert', $histOutput, function ($m) {
                        $m->from('bills@energycap.com', 'EnergyCAP Bill CAPture');
                        $m->to('bills@energycap.com')->subject("Usage Alert");
                    });
                }
            }
            
    
            // ******************* Accounts ****************** //
    
            // if the proposedVolume column is NULL it will be skipped
            if ($trans->proposedVolume_accts >= 0) {
        
                if ($trans->actual_newAccounts > ($trans->proposedVolume_accts + 10)) {
                    $acctOutput = array(); // set the empty array for the view
                    $acctOutput['clientName'] = $trans->clientName;
                    $acctOutput['totalContracted'] = $trans->proposedVolume_accts;
                    $acctOutput['actualUsage'] = $trans->actual_newAccounts;
                    $acctOutput['type'] = "Meter Enrollments";
                    $acctOutput['renewal'] = $trans->renewal_ecmaDate->toFormattedDateString();
                    
                    // send email
                    Mail::send('emails.trans-alert', $acctOutput, function ($m) {
                        $m->from('bills@energycap.com', 'EnergyCAP Bill CAPture');
                        $m->to('bills@energycap.com')->subject("Usage Alert");
                    });
                }
            }
        }
    }
}
