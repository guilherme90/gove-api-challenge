<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeNotificationRequest;
use App\UseCases\NotifyContactUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChangeNotificationController extends Controller
{
    public function __construct(private readonly NotifyContactUseCase $notifyContactUseCase)
    {
    }

    public function __invoke(ChangeNotificationRequest $request, int $id): JsonResponse
    {
        try {
            $input = $request->validated();
            $this->notifyContactUseCase->changeNotification($id, $input['scheduled_at']);

            return \response()->json([], 202);
        } catch (HttpException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
