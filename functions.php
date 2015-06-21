<?php

/**
 * Speedmeter functions and definitions
 *
 * @package Speedmeter
 */

// Enqueue child theme stylesheet, loading first the parent theme stylesheet.
function themify_custom_enqueue_child_theme_styles() {
	wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'themify_custom_enqueue_child_theme_styles' );

if ( ! function_exists( 'simple_life_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function simple_life_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s %3$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_html( get_the_time() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'simple-life' ),
		'<i class="fa fa-calendar"></i> <a href="' . esc_url( get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	
	/* Sean: add modification time */
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$modified_string = '<time class="entry-date" datetime="%1$s">%2$s %3$s</time>';
		
		$modified_string = sprintf( $modified_string,
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() ),
			esc_html( get_the_modified_time() )
		);
	
		$modified_on = '<i class="fa fa-calendar"></i> <a href="' . esc_url( get_day_link(get_the_modified_date('Y'), get_the_modified_date('m'), get_the_modified_date('j')) ) . '" rel="bookmark">' . $modified_string . '</a>';
		
		$posted_on .= ' (last edited ' . $modified_on . ')';
	}

	/* Sean: show coauthors */
	
	if ( function_exists( 'coauthors_posts_links' ) ) {
		$byline = '<i class="fa fa-user"></i>&nbsp;&nbsp;' . coauthors_posts_links(null, null, null, null, false);
	} else {
		$byline = sprintf(
			'<i class="fa fa-user"></i> '._x( '%s', 'post author', 'simple-life' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( 	get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
	}
	
	echo '<div class="byline">' . $byline . '</div><div class="posted-on">' . $posted_on . '</div>';
}
endif;