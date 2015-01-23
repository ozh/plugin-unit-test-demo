<?php
/**
 * Test the init function
 */
class Ozh_Demo_Init_Test extends WP_UnitTestCase {
    
    public $demo_plugin;
    
    function setUp() {
        parent::setUp();
        $this->demo_plugin = new Ozh_Demo_Plugin;
    }
    
    function test_init_plugin() {
        // Simulate WordPress init
        do_action( 'init' );

        $this->assertEquals( 10, has_action( 'save_post', array( $this->demo_plugin, 'add_meta_if_title' ) ) );
        
        global $shortcode_tags;
        $this->assertArrayHasKey( 'omglol', $shortcode_tags );
    }
    
}

