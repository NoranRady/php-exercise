<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApplicationService;
use App\Http\Requests\StoreApplicationRequest;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function store(StoreApplicationRequest $request)
    {
        $application = $this->applicationService->storeApplication($request->input('company_id'),
                                                                    $request->input('start_date'),
                                                                    $request->input('end_date'),
                                                                    $request->input('email') 
                                                                );
        return response()->json(['application' => $application], 201);
    }
}