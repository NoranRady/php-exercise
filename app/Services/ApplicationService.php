<?php

namespace App\Services;

use App\Models\Application;
use App\Repositories\ApplicationRepository;
use Carbon\Carbon;

class ApplicationService
{
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function storeApplication($companyId, $startDate, $endDate, $email): Application
    {
        $startDateFormatted = Carbon::createFromFormat('d-m-Y', $startDate)->format('Y-m-d');
        $endDateFormatted = Carbon::createFromFormat('d-m-Y', $endDate)->format('Y-m-d');
        return $this->applicationRepository->storeApplication($companyId, $startDateFormatted, $endDateFormatted, $email);
    }
}