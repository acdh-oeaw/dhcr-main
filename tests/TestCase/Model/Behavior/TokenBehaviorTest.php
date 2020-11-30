<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\TokenBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\TokenBehavior Test Case
 */
class TokenBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Behavior\TokenBehavior
     */
    public $Token;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Token = new TokenBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Token);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
