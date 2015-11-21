<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	$target = trim($_REQUEST[ 'ip' ]);

	// Set blacklist
	$substitutions = array(
		'&'  => '',
		';'  => '',
		'| ' => '',
		'-'  => '',
		'$'  => '',
		'('  => '',
		')'  => '',
		'`'  => '',
		'||' => '',
	);

	// Remove any of the charactars in the array (blacklist).
	$target = str_replace( array_keys( $substitutions ), $substitutions, $target );
	
	// Default response
	$result = "Host down";

	// Determine OS and execute the ping command.
	if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
		// Windows
		$cmd = shell_exec( 'ping  ' . $target );
	}
	else {
		// *nix
		$cmd = shell_exec( 'ping  -c 4 ' . $target );
	}

	// Was the host up?
	// Linux: 64 bytes from 127.0.0.1: icmp_req=1 ttl=64 time=0.023 ms
	// Windows: Reply from ::1: time<1ms
	if ( preg_match ( '*from*', $cmd ) ) {
		$result = "Host up";
	}
	
	// Feedback for the end user
	$html .= "<pre>{$result}</pre>";
}

?>
