<?php

namespace Tests\Unit\Http\Controllers\Api;

use Tests\TestCase;
use App\Services\ApplicationService;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Http\JsonResponse;
use Mockery;

class ApplicationControllerTest extends TestCase
{
    public function testStoreMethodReturnsJsonResponseWithStatusCode201()
    {
        $applicationServiceMock = Mockery::mock(ApplicationService::class);
        $applicationServiceMock->shouldReceive('storeApplication')->once();
        $requestMock = Mockery::mock(StoreApplicationRequest::class);
        $requestMock->shouldReceive('input')->with('company_id')->andReturn(1);
        $requestMock->shouldReceive('input')->with('start_date')->andReturn('2023-06-01');
        $requestMock->shouldReceive('input')->with('end_date')->andReturn('2023-06-30');
        $requestMock->shouldReceive('input')->with('email')->andReturn('john@example.com');
        $controller = new ApplicationController($applicationServiceMock);

        $response = $controller->store($requestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('Application Created Successfuly', $response->getData(true)[0]);
    }
}