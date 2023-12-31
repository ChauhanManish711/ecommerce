<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ActivityLog;

class DeleteActivitiesBulk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $activities;
    /**
     * Create a new job instance.
     */
    public function __construct($activities)
    {
        $this->activities = $activities;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $activities = $this->activities;
        foreach($activities as $activity)
        {
            ActivityLog::where('id',$activity->id)->delete();
        }
    }
}
