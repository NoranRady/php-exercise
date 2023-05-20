<?php

namespace Tests\Unit\Repositories;

use App\Repositories\CompanyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetCompanies()
    {
        // Create a new CompanyRepository object and call the getCompanies method
        $companyRepository = new CompanyRepository();
        $result = $companyRepository->getCompanies();

        // Assert that the result is a collection containing both companies
        $this->assertCount(2967, $result);

        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('symbol', $result[0]);
    }
}