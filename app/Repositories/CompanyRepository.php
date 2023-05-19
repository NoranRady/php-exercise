<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function getCompanies()
    {
        return Company::select('id','symbol')->get();
    }
}