<?php

namespace Database\Seeders;

use App\Models\Publication_type;
use App\Models\User;
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
        Publication_type::create([
            'name' => 'Jurnal Internasional'
        ]);
        Publication_type::create([
            'name' => 'Jurnal Nasional'
        ]);
        Publication_type::create([
            'name' => 'Prosiding Internasional'
        ]);
        Publication_type::create([
            'name' => 'Prosiding Nasional'
        ]);
        
    }
}
