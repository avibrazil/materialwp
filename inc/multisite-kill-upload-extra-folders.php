<?php

function kill_multisite_upload_extra_folders ( $upload ) {
	// Mimic what wp-includes/functions.php::_wp_upload_dir() does
	// Use whats on /wp-admin/network/site-settings.php?id={N} upload_path directly,
	// without creating the "site/{N}" folder

	$upload['basedir'] = trim(get_option( 'upload_path' ));
	if ( 0 !== strpos( $upload['basedir'], ABSPATH ) ) {
		// $dir is absolute, $upload_path is (maybe) relative to ABSPATH
		$upload['basedir'] = path_join( ABSPATH, $upload['basedir'] );
	}

	$upload['baseurl'] = get_option( 'upload_url_path' );
	$upload['path'] = $upload['basedir'] . $upload['subdir'];
	$upload['url'] = $upload['baseurl'] . $upload['subdir'];

	return $upload;
}


if ( defined( 'MULTISITE' ) ) {
	add_filter( 'upload_dir', 'kill_multisite_upload_extra_folders' );
}