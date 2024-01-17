<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateContactsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [];
        $csv = new \ParseCsv\Csv();
        $csv->titles = ['nome', 'email'];

        for ($i = 0; $i <= 10000; $i++) {
            $items[] = [
                'nome' => fake()->name(),
                'email' => fake()->email()
            ];
        }

        $csv->data = $items;

        $csv->save(getcwd() . '/storage/app/schedules/batch.csv');
    }
}
