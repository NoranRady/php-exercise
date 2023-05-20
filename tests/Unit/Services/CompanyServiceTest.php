<?php

namespace Tests\Unit\Services;

use App\Repositories\CompanyRepository;
use App\Services\CompanyService;
use PHPUnit\Framework\TestCase;

class CompanyServiceTest extends TestCase
{
    public function testGetCompanies()
    {
        // Create a mock CompanyRepository object
        $companyRepositoryMock = $this->getMockBuilder(CompanyRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Set up the mock CompanyRepository object to return an array of companies
        $companies = [
            ['id' => 1, 'name' => 'Company 1'],
            ['id' => 2, 'name' => 'Company 2'],
            ['id' => 3, 'name' => 'Company 3'],
        ];
        $companyRepositoryMock->expects($this->once())
            ->method('getCompanies')
            ->willReturn($companies);

        // Create a new CompanyService object using the mock CompanyRepository object
        $companyService = new CompanyService($companyRepositoryMock);

        // Call the getCompanies method on the CompanyService object
        $result = $companyService->getCompanies();

        // Assert that the result is an array containing the expected companies
        $this->assertEquals($companies, $result);
    }
}