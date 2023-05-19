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
        return $this->applicationRepository->storeApplication($companyId, $startDate, $endDate, $email);
    }
}