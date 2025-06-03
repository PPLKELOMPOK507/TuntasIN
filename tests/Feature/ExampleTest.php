<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testBasic(): void
    {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSee('started');
    });
    }
}
