<?php

namespace App\Repositories;

use App\Models\Application;

class ApplicationRepository
{
    public function storeApplication($companyId, $startDate, $endDate, $email): Application
    {
        $application = new Application();
        $application->company_id = $companyId;
        $application->start_date = $startDate;
        $application->end_date = $endDate;
        $application->email = $email;
        $application->save();
        return $application;
    }
}
