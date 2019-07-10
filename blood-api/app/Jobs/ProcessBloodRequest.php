<?php

namespace App\Jobs;

use App\BloodGroup;
use App\BloodRequest;
use App\Helpers\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBloodRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $bloodRequest;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BloodRequest $bloodRequest)
    {
        //
        $this->bloodRequest = $bloodRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
    }

    public function sendMultipleNotifications($personGroup, $bloodRequest)
    {
        \Log::info('sending');

        // foreach ($personGroup as $key => $person) {
        //     # code...
        //     // Realtime::sendNotification($person->email, []);
        // }
    }
}
