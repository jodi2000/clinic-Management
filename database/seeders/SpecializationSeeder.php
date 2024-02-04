<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            ['title' => 'Pediatrician'],
            ['title' => 'Psychiatrist'],
            ['title' => 'Radiologist'],
        ];

        foreach ($specializations as $specializationData) {
            Specialization::create($specializationData);
        }
    }
}
