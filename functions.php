<?php
/**
 * Plugin Name: Remove noreferrer
 * Plugin URI: https://www.basefold.com/how-do-i-remove-noreferrer-in-wordpress/
 * Description: Filters and removes noreferrer from the rel attribute.
 * Version: 1.0
 * Author: basefold
 */

// Remove extraneous whitespace
function basefold_remove_whitespace( $input ) {
    return trim( preg_replace( '#\s+#', ' ', $input ) );
}

// Replace noreferrer
function basefold_replace_rel ( $matches ) {
		// String '<a href="https://www.example.com" target="_blank" rel="noreferrer noopener">external example link</a>'
		$anchor_element_prefix = $matches[1]; // returns: '<a href="https://www.example.com" target="_blank" rel='
		$anchor_rel = basefold_remove_whitespace( str_ireplace( 'noreferrer', '', $matches[3] ) ); // returns: 'noopener'
		$anchor_element_suffix = $matches[4]; // returns: '>external example link</a>'
		
		return $anchor_element_prefix . $anchor_rel . $anchor_element_suffix;
};

// Sayonara noreferrer
function basefold_remove_noreferrer( $content ) {

    $regex = '#(<a\s.*rel=)([\"\']??)(.+)(>.*<\/a>)#i';
    
    return preg_replace_callback( $regex, 'basefold_replace_rel', $content );
}
add_filter( 'the_content', 'basefold_remove_noreferrer', 999 );
?>
