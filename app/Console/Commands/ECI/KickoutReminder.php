<?php

namespace App\Console\Commands\ECI;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KickoutReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecbc:kickout_reminder';

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
    
        // loop through clients
        foreach ($clients as $client) {
            
            // get partner files that are not processed and open and kicked out
            $partnerFiles = $client->partnerFiles()->where('kickedOut','=','1')->where('closed','=',0)->where('readyToProcess','=',0)->get();
            
            // if no partner files exist, move to next client
            if(count($partnerFiles) == 0) {
                // no open partner files
                continue;
            }
            else {
                
                // loop through partner files
                foreach ($partnerFiles as $partnerFile) {
                    
                    // look for open kickouts
                    $kickouts = $partnerFile->kickoutFiles()->where('processed',0)->get();
                    
                    // if no kickouts, move on to next partner file
                    if (count($kickouts) == 0) {
                        // no kickouts
                        continue;
                    }
                    else {
                        // kickouts found.
                        
                        // get date of last email + grace period
                        $graceEnd = $partnerFile->lastKickoutEmail->copy()->addDays($client->kickoutGracePeriod);
                        $today = new Carbon();
    
                        //if the grace period is equal to or greater than the current date then send a kickout reminder
                        if($today->gt($graceEnd)) {
                            // this should be reminded.
                            $reminderData = array();
                            $reminderData['client'] = $client;
                            $reminderData['partnerFile'] = $partnerFile;
                            $reminderData['kickouts'] = $kickouts;
    
                            // send email
                            Mail::send('emails.kickout-reminder', $reminderData, function ($m) use ($client) {
                                $m->from('bills@energycap.com', 'EnergyCAP Bill CAPture');
                                $m->to($client->clientEmails())->subject("Kickout Report Reminder");
                                $m->bcc($client->bccEmails());
                            });
                            
                            // update lastKickoutEmail column to reflect when the latest reminder email was last sent
                            $partnerFile->lastKickoutEmail = $today->toDateTimeString();
                            $partnerFile->save();
                            
                            $this->info('Reminder sent for partner file ' . $partnerFile->partnerFileID);
                            Log::info('Reminder sent for partner file ' . $partnerFile->partnerFileID);
                        }
                        else {
                            // criteria not met, reminder not sent
                            $this->info('Reminder not sent for partner file ' . $partnerFile->partnerFileID);
                            Log::info('Reminder not sent for partner file ' . $partnerFile->partnerFileID);
                        }
                    }
                }
            }
            
        }
    }
}
