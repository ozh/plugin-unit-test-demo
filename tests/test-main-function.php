<?php
/**
 * Test the plugin's main function
 */
class Ozh_Demo_Main_Func_Test extends WP_UnitTestCase {
    
	function test_main_if_noob_user() {
        $post_id = $this->factory->post->create();
        $user_id = $this->factory->user->create( array( 'role' => 'subscriber' ) );
        wp_set_current_user( $user_id );
        
        $demo_plugin = $this->getMockBuilder( 'Ozh_Demo_Plugin' )
            ->setMethods( array( 'get_song_title' ) )
            ->getMock();
        
        $demo_plugin->expects( $this->never() )
            ->method( 'get_song_title' );
        
        $demo_plugin->add_meta_if_title( $post_id );
	}
    
    
    function remote_request_return() {
        return array(
            array( false, 0 ),
            array( rand_str( 32 ), 1 ),
        );
    }
    
    /**
    * @dataProvider remote_request_return
    */    
	function test_main_if_leet_user( $remote_response, $expected_calls ) {
        $post_id = $this->factory->post->create();
        $user_id = $this->factory->user->create( array( 'role' => 'editor' ) );
        wp_set_current_user( $user_id );
        
        $demo_plugin = $this->getMockBuilder( 'Ozh_Demo_Plugin' )
            ->setMethods( array( 'get_song_title', 'update_meta' ) )
            ->getMock();
            
        $demo_plugin->song_title = $remote_response;
        
        $demo_plugin->expects( $this->once() )
            ->method( 'get_song_title' );
        
        $demo_plugin->expects( $this->exactly( $expected_calls ) )
            ->method( 'update_meta' );
        
        $demo_plugin->add_meta_if_title( $post_id );
	}
    

	function test_main_if_autosave() {
        $post_id = $this->factory->post->create();
        $user_id = $this->factory->user->create( array( 'role' => 'editor' ) );
        wp_set_current_user( $user_id );
        
        define( 'DOING_AUTOSAVE', true );        
        
        $demo_plugin = $this->getMockBuilder( 'Ozh_Demo_Plugin' )
            ->setMethods( array( 'get_song_title' ) )
            ->getMock();
        
        $demo_plugin->expects( $this->never() )
            ->method( 'get_song_title' );
        
        $demo_plugin->add_meta_if_title( $post_id );
	}

}

