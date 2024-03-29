<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PagesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\PagesController Test Case
 *
 * @uses \App\Controller\PagesController
 */
class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.Countries',
        'app.Emails'
    ];

    /**
     * Test follow method
     *
     * @return void
     * @uses \App\Controller\PagesController::follow()
     */
    public function testFollow(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test info method
     *
     * @return void
     * @uses \App\Controller\PagesController::info()
     */
    public function testInfo(): void
    {
        $this->get('/info');
        $this->assertResponseOk();
    }

    /**
     * Test display method
     *
     * @return void
     * @uses \App\Controller\PagesController::display()
     */
    public function testDisplay(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
