<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeds/companies.json'));
        $data = json_decode($json, true);
    
        $companies = [];
    
        foreach ($data as $company) {
            $companies[] = [
                'company_name' => $company['Company Name'],
                'financial_status' => $company['Financial Status'],
                'market_category' => $company['Market Category'],
                'round_lot_size' => $company['Round Lot Size'],
                'security_name' => $company['Security Name'],
                'symbol' => $company['Symbol'],
                'test_issue' => $company['Test Issue'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::table('companies')->insert($companies);
    }
}