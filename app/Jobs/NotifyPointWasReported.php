<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\PointWasReported;
use App\Models\Point;

class NotifyPointWasReported implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Point $point;
    private string $reason;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Point $point, string $reason)
    {
        $this->point = $point;
        $this->reason = $reason;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->point->user->notify(new PointWasReported($this->point, $this->reason));
    }
}
