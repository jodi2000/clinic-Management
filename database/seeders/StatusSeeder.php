<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['title' => 'pending'],
            ['title' => 'accepted'],
            ['title' => 'rejected'],
            ['title' => 'canceled'],
            ['title' => 'expired'],


        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
