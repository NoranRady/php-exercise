<?php

namespace App\Services;

use App\Models\Application;
use App\Repositories\ApplicationRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class ApplicationService
{
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function storeApplication($companyId, $startDate, $endDate, $email): Application
    {
        $application =  $this->applicationRepository->storeApplication($companyId, $startDate, $endDate, $email);
        $applicationData =  $this->applicationRepository->getApplication($application->id);
        Mail::to($application->email)->send(new WelcomeEmail($applicationData));
        return $application;
    }
}