<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadScheduleFileRequest;
use App\Jobs\CreateContactScheduleJob;
use App\UseCases\FileProcessUseCase;
use Illuminate\Http\JsonResponse;

class UploadScheduleFileController extends Controller
{
    public function __construct(private readonly FileProcessUseCase $fileProcessUseCase)
    {
    }

    public function __invoke(UploadScheduleFileRequest $request): JsonResponse
    {
        try {
            $request->file('file')->storeAs('schedules', 'contacts.csv');

            CreateContactScheduleJob::dispatch($this->fileProcessUseCase);
            return response()->json([], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
