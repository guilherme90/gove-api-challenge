<?php

namespace App\Http\Controllers;

use App\Jobs\CreateContactScheduleJob;
use App\UseCases\FileProcessUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadScheduleFileController extends Controller
{
    public function __construct(private readonly FileProcessUseCase $fileProcessUseCase)
    {
    }

    public function store(Request $request): JsonResponse
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
