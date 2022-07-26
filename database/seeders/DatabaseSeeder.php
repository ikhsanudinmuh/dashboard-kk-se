<?php

namespace Database\Seeders;

use App\Models\AbdimasType;
use App\Models\JournalAccreditation;
use App\Models\Lab;
use App\Models\PatentType;
use App\Models\PublicationType;
use App\Models\ResearchType;
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
        //menambahkan data tipe publikasi
        $publication_type = [
            ['name' => 'International Journal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'National Journal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'International Prosiding', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'National Prosiding', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        
        PublicationType::insert($publication_type);
        
        //menambahkan data tipe akreditasi jurnal
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
        
        JournalAccreditation::insert($journal_accreditation);
        
        //menambahkan data lab
        $lab = [
            ['name' => 'Advanced Software Engineering', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Mobile and Innovation', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Information Science and Engineering', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Technology Enhanced Learning Center', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            
        ];
        
        Lab::insert($lab);
        
        //menambahkan data research_type
        $research_type = [
            ['name' => 'Internal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'External', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Independent', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        ResearchType::insert($research_type);

        //menambahkan data patent_type
        $patent_type = [
            ['name' => 'Copyright', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Patent', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
    
        PatentType::insert($patent_type);

        //menambahkan data abdimas_type
        $abdimas_type = [
            ['name' => 'Internal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'External', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
    
        AbdimasType::insert($abdimas_type);
    }
}
