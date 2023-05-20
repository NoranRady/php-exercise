<?php

namespace Tests\Unit\Http\Controllers\Api;

use App\Http\Controllers\Api\CompanyController;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function testIndexReturnsJsonResponse()
    {
        $serviceMock = $this->createMock(CompanyService::class);
        $serviceMock->expects($this->once())
            ->method('getCompanies')
            ->willReturn([]);

        $controller = new CompanyController($serviceMock);
        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
    
    public function testIndexReturnsCompaniesFromService()
    {
        $companies = [
            ['symbol' => 'AAPL', 'id' => '1'],
            ['symbol' => 'GOOG', 'id' => '2'],
        ];
    
        $serviceMock = $this->createMock(CompanyService::class);
        $serviceMock->expects($this->once())
            ->method('getCompanies')
            ->willReturn($companies);
    
        $controller = new CompanyController($serviceMock);
        $response = $controller->index();
    
        $responseData = json_decode(json_encode($response->getData()), true);
    
        $this->assertEquals($companies, $responseData);
    }
}