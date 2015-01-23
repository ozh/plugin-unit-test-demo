<?php

$_tests_dir = getenv('WP_TESTS_DIR');
if ( !$_tests_dir ) $_tests_dir = '/tmp/wordpress-tests-lib';

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	require dirname( __FILE__ ) . '/../ozh-demo-plugin-for-unit-tests.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';

function ut_var_dump( $what ) {
    ob_start();
    var_dump( $what );
    $display = ob_get_contents();
    ob_end_clean();
    fwrite( STDERR, $display );
}