<?php

namespace Tests\Unit\Http\Controllers\Web;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    use WithFaker;
    
    public function test_create_method_returns_view()
    {
        $response = $this->get('/applications/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('applications.create');
    }
    
    public function test_historics_method_returns_view_with_symbol()
    {
        $symbol = $this->faker->word;
        
        $response = $this->get("/applications/historics/{$symbol}");
        
        $response->assertStatus(200);
        $response->assertViewIs('applications.historics');
        $response->assertViewHas('symbol', $symbol);
    }
}