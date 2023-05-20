<?php

namespace Tests\Unit\Services;

use App\Mail\WelcomeEmail;
use App\Models\Application;
use App\Repositories\ApplicationRepository;
use App\Services\ApplicationService;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class ApplicationServiceTest extends TestCase
{
    public function testStoreApplicationReturnsApplication()
    {
        $applicationData = [
            'company_id' => 1,
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-15',
            'email' => 'test@example.com',
        ];
        $application = new Application($applicationData);
        $applicationRepoMock = Mockery::mock(ApplicationRepository::class);
        $applicationRepoMock->shouldReceive('storeApplication')
            ->once()
            ->with($applicationData['company_id'], $applicationData['start_date'], $applicationData['end_date'], $applicationData['email'])
            ->andReturn($application);
        $applicationRepoMock->shouldReceive('getApplication')
            ->once()
            ->with($application->id)
            ->andReturn($applicationData);
        Mail::fake();
        Mail::assertNothingSent();
        $service = new ApplicationService($applicationRepoMock);
        $result = $service->storeApplication($applicationData['company_id'], $applicationData['start_date'], $applicationData['end_date'], $applicationData['email']);
        $this->assertEquals($application, $result);
    }

    public function testStoreApplicationSendsWelcomeEmail()
    {
        $applicationData = [
            'company_id' => 1,
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-15',
            'email' => 'test@example.com',
            'company' => [
                "id" => 80,
                "company_name" => "Affimed N.V.",
                "financial_status" => "N",
                "market_category" => "G",
                "round_lot_size" => 100,
                "security_name" => "Affimed N.V. - Common Stock",
                "symbol" => "AFMD",
                "test_issue" => "N",
                "created_at" => "2023-05-18 20:43:57",
                "updated_at" => "2023-05-18 20:43:57"
            ]
        ];
        $application = new Application($applicationData);
        $applicationRepoMock = Mockery::mock(ApplicationRepository::class);
        $applicationRepoMock->shouldReceive('storeApplication')
            ->once()
            ->with($applicationData['company_id'], $applicationData['start_date'], $applicationData['end_date'], $applicationData['email'])
            ->andReturn($application);
        $applicationRepoMock->shouldReceive('getApplication')
            ->once()
            ->with($application->id)
            ->andReturn($applicationData);
        Mail::fake();
        Mail::assertNothingSent();
        $service = new ApplicationService($applicationRepoMock);
        $service->storeApplication($applicationData['company_id'], $applicationData['start_date'], $applicationData['end_date'], $applicationData['email']);
        Mail::assertSent(WelcomeEmail::class, function ($mail) use ($applicationData) {
            return $mail->hasTo($applicationData['email']);
        });
    }


}