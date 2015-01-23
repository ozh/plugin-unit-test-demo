<?php
/**
 * Test the remote request functions
 */
class Ozh_Demo_Remote_Test extends WP_UnitTestCase {
    
    public $demo_plugin;
    
	function setUp() {
		parent::setUp();
        $this->demo_plugin = new Ozh_Demo_Plugin;
    }
    
    function return_valid_html() {
        $html = "HTML HTML blah blah
            <div id='playerartistname'>Slayer</div>
            <div id='playersongname'>Raining Blood</div>
            blah blah MORE HTML";
        
        return array( 'body' => $html );
    }
    
    function return_crap_html() {
        return array( 'body' => "Error 500 - come back later" );
    }

    function return_no_html() {
        return array( );
    }
	
    function test_remote_request_valid_HTML() {
        add_filter( 'pre_http_request', array( $this, 'return_valid_html' ) );
        
        $this->assertSame( 'Slayer - Raining Blood', $this->demo_plugin->get_song_title() );
    }

    function test_remote_request_invalid_HTML() {
        add_filter( 'pre_http_request', array( $this, 'return_crap_html' ) );
        $this->assertFalse( $this->demo_plugin->get_song_title() );
        
        add_filter( 'pre_http_request', array( $this, 'return_no_html' ) );
        $this->assertFalse( $this->demo_plugin->get_song_title() );
    }

}
