<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\ContactSchedule;
use App\UseCases\FileProcessUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateContactScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly FileProcessUseCase $fileProcessUseCase)
    {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('[CreateContactScheduleJob] Job started');

        $this->fileProcessUseCase->process();

        Log::info('[CreateContactScheduleJob] Job finished');
    }
}
