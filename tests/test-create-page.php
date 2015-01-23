<?php
/**
 * Test page creation
 */
class Ozh_Demo_Create_Page_Test extends WP_UnitTestCase {
    
    public $demo_plugin;
    
	public static function setUpBeforeClass() {
		global $wp_rewrite;
        $wp_rewrite->init();
		$wp_rewrite->set_permalink_structure( '/%year%/%post_id%/' );
		$wp_rewrite->flush_rules();
	}

	public static function tearDownAfterClass() {
		global $wp_rewrite;
		$wp_rewrite->init();
	}
    
    function setUp(){
        parent::setUp();
        $this->demo_plugin = new Ozh_Demo_Plugin;
    }

    function test_create_page_one_way() {
        $this->go_to( '/code-is-poterie/' );
		$this->assertQueryTrue( 'is_404' );
        
        $this->demo_plugin->create_page();
        $this->go_to( '/code-is-poterie/' );
		$this->assertQueryTrue( 'is_page', 'is_singular' );
    }
    
    function test_create_page_another_way() {
        $page_id = $this->demo_plugin->create_page();
        $url = get_permalink( $page_id );
        $this->go_to( $url );
        $this->assertQueryTrue( 'is_page', 'is_singular' );
        $this->assertEquals( 'Code is Poterie', get_the_title( $page_id ) );
    }
}

