<?php
/**
 * Test the constructor function
 */
class Ozh_Demo_Construct_Test extends WP_UnitTestCase {
    
    public $demo_plugin;
    
    function setUp() {
        parent::setUp();
        $this->demo_plugin = new Ozh_Demo_Plugin;
    }
    
	function test_construct() {
        $this->assertEquals( 10, has_action( 'init', array( $this->demo_plugin, 'init_plugin' ) ) );
        $this->assertGreaterThan( 0, did_action( 'ozh_demo_plugin_loaded' ) );
	}
        
}

