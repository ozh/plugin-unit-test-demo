<?php
/**
 * Test the DB functions
 */
class Ozh_Demo_DB_Test extends WP_UnitTestCase {
    
	function test_create_DB() {
        global $wpdb;
        
        $demo_plugin = new Ozh_Demo_Plugin;
        $created = $demo_plugin->create_tables();
        
        // ut_var_dump( current( $created ) );
        // string(30) "Created table wptests_ozh_demo"
        
        $this->assertStringStartsWith( "Created table ", current( $created ) );
	}
}

