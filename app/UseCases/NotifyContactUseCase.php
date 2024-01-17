<?php

namespace App\UseCases;

use App\Models\ContactSchedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class NotifyContactUseCase
{
    public function notify(): void
    {
        ContactSchedule::query()
            ->with('contact')
            ->where('deleted_at', null)
            ->where('notified', false)
            ->chunk(500, function (Collection $items) {
                foreach ($items as $item) {
                    $item->updated_at = now();
                    $item->notified = true;
                    $item->save();

                    Log::info('[NotifyContactUseCase] Contact notified', [
                        'id' => $item->id,
                        'contact' => [
                            'id' => $item->contact->id,
                            'name' => $item->contact->name,
                            'email' => $item->contact->email
                        ]
                    ]);
                }
            });
    }
}
