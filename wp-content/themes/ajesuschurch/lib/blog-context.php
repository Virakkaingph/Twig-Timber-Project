<?php
/*
 * Use to initialize context and reduce duplication
 * in our template files.
 */

// Use blog page banner & foreground
$blog_page_id = get_option('page_for_posts');
$blog_page = new TimberPost( $blog_page_id );
$context['header_bg'] = set_bg_id( $blog_page->vibe_banner, 'vibe-banner' );
$context['foreground'] = $blog_page->foreground;
