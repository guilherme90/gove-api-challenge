<?php

namespace App\UseCases;

use App\Models\ContactSchedule;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NotifyContactUseCase
{
    public function contactPaginate(string $notified): Paginator
    {
        return ContactSchedule::query()
            ->with('contact')
            ->where('notified', $notified === 'on')
            ->simplePaginate(2);
    }

    public function changeNotification(int $id, string $scheduledAt): void
    {
        $contact = ContactSchedule::query()
            ->where('id', $id)
            ->first();

        if (!$contact) {
            throw new HttpException(404, 'Registro não encontrado');
        }

        $contact->update([
            'scheduled_at' => $scheduledAt
        ]);
    }

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
