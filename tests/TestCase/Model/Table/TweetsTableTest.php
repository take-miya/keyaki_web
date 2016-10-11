<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TweetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TweetsTable Test Case
 */
class TweetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TweetsTable
     */
    public $Tweets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tweets'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Tweets') ? [] : ['className' => 'App\Model\Table\TweetsTable'];
        $this->Tweets = TableRegistry::get('Tweets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tweets);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
