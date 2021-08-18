<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\DiscoveryCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\DiscoveryCommand Test Case
 *
 * @uses \App\Command\DiscoveryCommand
 */
class DiscoveryCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();
    }
    /**
     * Test execute method
     *
     * @return void
     */
    public function testExecute(): void
    {
        $this->exec('discovery');
        $this->assertFileExists(WWW_ROOT.'js/idp_select/DiscoFeed.json');
    }
}
