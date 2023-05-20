<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Application;
use App\Repositories\ApplicationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicationRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreApplication()
    {
        // Create a new ApplicationRepository object
        $applicationRepository = new ApplicationRepository();

        // Call the storeApplication method with some test data
        $companyId = 1;
        $startDate = '2022-01-01';
        $endDate = '2022-12-31';
        $email = 'test@example.com';
        $application = $applicationRepository->storeApplication($companyId, $startDate, $endDate, $email);

        // Assert that the application was saved to the database
        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'company_id' => $companyId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'email' => $email,
        ]);

        // Assert that the application object returned by the method is an instance of the Application model class
        $this->assertInstanceOf(Application::class, $application);
    }

    public function testGetApplication()
    {
        // Create a new Application object and save it to the database
        $application = new Application();
        $application->company_id = 1;
        $application->start_date = '2022-01-01';
        $application->end_date = '2022-12-31';
        $application->email = 'test@example.com';
        $application->save();

        // Create a new ApplicationRepository object and call the getApplication method with the ID of the saved application
        $applicationRepository = new ApplicationRepository();
        $result = $applicationRepository->getApplication($application->id);

        $this->assertArrayHasKey('company', $result);
        $this->assertArrayHasKey('id', $result);
    }
}