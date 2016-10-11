<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnalyticsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnalyticsTable Test Case
 */
class AnalyticsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnalyticsTable
     */
    public $Analytics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.analytics'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Analytics') ? [] : ['className' => 'App\Model\Table\AnalyticsTable'];
        $this->Analytics = TableRegistry::get('Analytics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Analytics);

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
