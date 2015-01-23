<?php
/**
 * Test the update meta function
 */
class Ozh_Demo_Update_Meta_Test extends WP_UnitTestCase {
    
    public $demo_plugin;
    
	function setUp() {
		parent::setUp();
        $this->demo_plugin = new Ozh_Demo_Plugin;
	}
    
	function test_update_meta() {
        $post_id = $this->factory->post->create();
        $song_title = rand_str( 32 );
        
        $this->demo_plugin->post_id    = $post_id;
        $this->demo_plugin->song_title = $song_title;
        
        $this->assertEmpty( get_post_meta( $post_id, 'with_song' ) );
        $this->demo_plugin->update_meta();
        $this->assertNotEmpty( get_post_meta( $post_id, 'with_song' ) );
	}
}

