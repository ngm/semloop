<?php
add_action( 'wp_enqueue_scripts', 'semloop_enqueue_styles' );
function semloop_enqueue_styles() {
 
    $parent_style = 'sempress'; 
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'semloop',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

wp_embed_register_handler( 'invidious_watch', '#https?://invidio\.us/watch\?v=([A-Za-z0-9\-_]+)#i', 'wp_embed_handler_invidious' );
wp_embed_register_handler( 'invidious_embed', '#https?://invidio\.us/embed/([A-Za-z0-9\-_]+)#i', 'wp_embed_handler_invidious' );
function wp_embed_handler_invidious( $matches, $attr, $url, $rawattr ) {
    $embed = sprintf(
        '<iframe src="https://invidio.us/embed/%1$s" frameborder="0" scrolling="no" marginwidth="0" marginheight="0" width="600" height="400"></iframe>',
        esc_attr($matches[1])
    );

    return $embed;
}

function sempress_posted_on() {
    printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark" class="url u-url"><time class="entry-date updated published dt-updated dt-published" datetime="%3$s" itemprop="dateModified datePublished">%4$s</time></a><address class="byline"> <span class="sep"> by </span> <span class="author p-author vcard hcard h-card" itemprop="author " itemscope itemtype="http://schema.org/Person">%5$s <a class="url uid u-url u-uid fn p-name" href="%6$s" title="%7$s" rel="author" itemprop="url"><span itemprop="name">%8$s</span></a></span></address>', 'sempress' ),
	esc_url( get_permalink() ),
	esc_attr( get_the_time() ),
	esc_attr( get_the_date( 'c' ) ),
	esc_html( get_the_date() ),
	get_avatar( get_the_author_meta( 'ID' ), 240 ),
	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
	esc_attr( sprintf( __( 'View all posts by %s', 'sempress' ), get_the_author() ) ),
        esc_html( get_the_author() )
    );
}
