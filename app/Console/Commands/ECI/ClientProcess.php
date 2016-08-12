<?php

namespace App\Console\Commands\ECI;

use App\Models\SystemData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ClientProcess extends Command
{
    const CLIENT_PROCESS_ID = 4;
    
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecbc:client_process';

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
        //
        
        $this->checkClientProcessStatus();
    }
    
    
    private function checkClientProcessStatus()
    {
        // get info from systemData table
        $systemData = SystemData::find(self::CLIENT_PROCESS_ID);
    
        // get time differences
        $currentTime = new Carbon();
        $intervalDiff = $systemData->notifyTimestamp->diffInMinutes($currentTime);
        $totalRun = $systemData->timestamp->diffInMinutes($currentTime);
        
        // if the time comparison is greater than or equal to the $interval value then send an alert
        if ($intervalDiff >= $systemData->notifyInterval) {
            $this->info("Processor has been running for " . (int) ($totalRun / 60) . " hours and " . $totalRun % 60 . " minutes.");
    
            $emailContent = array();
            $emailContent['process'] = 'Client';
            $emailContent['process_time'] = $totalRun;
            $emailContent['timestamp'] = $systemData->timestamp->toDayDateTimeString();
             
            // process running too long, send alert email
            $subject = "CLIENT PROCESS " . strtoupper($systemData->status) . " STUCK";
    
            // send email
            Mail::send('emails.stuck-process-alert', $emailContent, function ($m) use ($subject) {
                $m->from('bills@energycap.com', 'EnergyCAP Bill CAPture');
                $m->to('bills@energycap.com')->subject($subject);
            });
            
            // send push alert
            //TODO: Send push alert notification
        }
        
        return $systemData->value;
    }
}
