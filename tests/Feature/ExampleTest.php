<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ExampleTest extends TestCase
{



    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }



    public function testIndex()
    {
        $response = $this->call('GET', 'welcome');
        $response->assertStatus(200);
    }


    public function testRouteChiffre()
    {
        $response = $this->call('GET', '3');
        $response->assertSuccessful();
        $this->assertEquals('Je suis la page 3', $response->getContent());
    }
}

