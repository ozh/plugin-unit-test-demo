<?php
/**
 * Test the Activate function
 */
class Ozh_Demo_Activate_Test extends WP_UnitTestCase {
    
	function test_activate() {
        $demo_plugin = $this->getMockBuilder( 'Ozh_Demo_Plugin' )
            ->setMethods( array( 'create_tables', 'create_page' ) )
            ->getMock();
        
        $demo_plugin->expects( $this->once() )
            ->method( 'create_tables' );

        $demo_plugin->expects( $this->once() )
            ->method( 'create_page' );
        
        $demo_plugin->activate();
	}
}

