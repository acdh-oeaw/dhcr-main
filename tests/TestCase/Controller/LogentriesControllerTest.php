<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\LogentriesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\LogentriesController Test Case
 *
 * @uses \App\Controller\LogentriesController
 */
class LogentriesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Logentries',
        'app.LogentryCodes',
        'app.Users',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\LogentriesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
