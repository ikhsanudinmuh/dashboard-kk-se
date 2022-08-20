<?php

namespace Database\Seeders;

use App\Models\Journal_accreditation;
use App\Models\Publication_type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //add publication_type data
        $publication_type = [
            ['name' => 'International Journal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'National Journal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'International Prosiding', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'National Prosiding', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        Publication_type::insert($publication_type);
        
        //add journal_accreditation data
        $journal_accreditation = [
            ['name' => 'Q1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Q2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Q3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Q4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'S1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'S2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'S3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'S4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'S5', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'S6', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Not Accredited', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Unidentified', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        Journal_accreditation::insert($journal_accreditation);
    }
}
