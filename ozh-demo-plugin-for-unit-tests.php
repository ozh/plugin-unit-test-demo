<?php

/*
Plugin Name: Unit Testing Demo Plugin
Plugin URI: https://github.com/ozh/plugin-unit-test-demo
Description: Demo plugin. DO NOT ACTIVATE! It's just for the unit tests and the lulz
Author: Ozh
Version: 0.1
Author URI: http://ozh.org
*/

class Ozh_Demo_Plugin {
    
    public $post_id;
    public $song_title;

    /**
     * Class contructor
     */
    function __construct() {
        add_action( 'init', array( $this, 'init_plugin' ) );
        do_action( 'ozh_demo_plugin_loaded' );
    }

    /**
     * Plugin init: starts all that's needed
     */
    function init_plugin() {
        add_action( 'save_post', array( $this, 'add_meta_if_title' ) );
        add_shortcode( 'omglol', array( $this, 'add_short_code' ) );
    }

    /**
     * That would be the main plugin function:
     * When a post is saved, under required circumstances, the plugin would:
     *   - get a song title from a remote web radio
     *   - save that song title as post meta data
     *   - save that song title in a text file
     */
    function add_meta_if_title( $post_id ) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        
        $this->get_song_title();
        
        if( $this->song_title ) {
            $this->update_meta();
        }
    }

    /**
     * Content of [omglol] shortcode
     *
     * @codeCoverageIgnore
     */
    function add_short_code( $atts ) {
        return "omg lol !";
    }

    /**
     * Update post meta data 'with_song' with song title
     */
    function update_meta() {
        update_post_meta( $this->post_id, 'with_song', $this->song_title );
    }

    /**
     * Get current song title played on that cool web radio
     */
    function get_song_title(){
        $remote = 'http://www.radiometal.com/player/song_infos_player.txt';
        $body   = wp_remote_retrieve_body( wp_remote_get( $remote ) );
        /* sample return:
        <div id='playerartistname'>Metallica</div> <div id='playersongname'>Master of Puppets</div>
        */
        preg_match_all( "!<div id='[^']*'>([^<]*)</div>!", $body, $matches ) ;
        // $matches[1][0]: artist - $matches[1][1]: song name
        
        if( $matches[1] ) {
            return $matches[1][0] . ' - ' . $matches[1][1];
        } else {
            return false;
        }
    }
    
    /**
     * Create a custom page
     */
    function create_page() {
        global $user_ID;
        $page = array(
            'post_type'    => 'page',
            'post_title'   => 'Code is Poterie',
            'post_content' => 'Opération Template du Dessert',
            'post_status'  => 'publish',
            'post_author'  => $user_ID,
        );
        
        return wp_insert_post( $page );
    }
    
    /**
    * Create a custom table
    */    
    function create_tables() {
        global $wpdb;

        $table_name = $wpdb->prefix . "ozh_demo";
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
          `id` mediumint(9) NOT NULL AUTO_INCREMENT,
          `time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          `name` tinytext NOT NULL,
          `text` text NOT NULL,
          UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        return dbDelta( $sql );
    }
    
    /**
    * Things to do when the plugin is activated
    */
    function activate() {
        $this->create_tables();
        $this->create_page();
    }

}

new Ozh_Demo_Plugin;

register_activation_hook( __FILE__, array( 'Ozh_Demo_Plugin', 'activate' ) );

