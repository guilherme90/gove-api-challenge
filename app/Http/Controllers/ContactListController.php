<?php

namespace App\Http\Controllers;

use App\UseCases\NotifyContactUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactListController extends Controller
{
    public function __construct(private readonly NotifyContactUseCase $notifyContactUseCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $notified = $request->query('notified');
        return \response()->json($this->notifyContactUseCase->contactPaginate($notified));
    }
}
