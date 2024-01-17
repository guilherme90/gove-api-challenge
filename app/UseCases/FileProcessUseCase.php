<?php

namespace App\UseCases;

use App\Models\Contact;
use App\Models\ContactSchedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ParseCsv\Csv;

class FileProcessUseCase
{
    private function readFile(): Collection
    {
        $file = Storage::disk('local')->get('schedules/contacts.csv');

        if (!$file) {
            return \collect();
        }

        $parseCsv = new Csv();
        $csv = $parseCsv->parseFile(Storage::disk('local')->get('schedules/contacts.csv'));

        return \collect($csv)->chunk(1000);
    }

    public function process(): void
    {
        $items = $this->readFile();

        if (!$items->count()) {
            return;
        }

        Log::info('[FileProcessUseCase] Starting read of items', ['total' => count($items)]);
        foreach ($items as $chunk) {
            foreach ($chunk as $item) {
                $hasContact = Contact::select(['id', 'email'])
                    ->where('email', $item['email'])
                    ->first();

                if ($hasContact) {
                    Log::warning('[FileProcessUseCase] Contact already exists', ['email' => $hasContact['email']]);
                    ContactSchedule::create([
                        'contact_id' => $hasContact['id'],
                        'scheduled_at' => now()->addMinutes(5)
                    ]);
                    continue;
                }

                $contact = Contact::create([
                    'name' => $item['nome'],
                    'email' => $item['email']
                ]);
                $contactSchedule = ContactSchedule::create([
                   'contact_id' => $contact['id'],
                   'scheduled_at' => now()->addMinutes(5)
                ]);

                Log::info('[FileProcessUseCase] Contact scheduled to notify', [
                    'email' => $item['email'],
                    'scheduled_at' => $contactSchedule['scheduled_at']
                ]);
            }
        }

        Storage::disk('local')->delete('schedules/contacts.csv');
        Log::info('[FileProcessUseCase] File deleted successfully');
    }
}
