<?php

namespace App\Jobs;

use App\Events\ExportFinishedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportPdfDataJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $userId)
    {
    }

    public function handle(): void
    {
        sleep(5);

        event(new ExportFinishedEvent($this->userId, 'file.pdf'));
    }
}
