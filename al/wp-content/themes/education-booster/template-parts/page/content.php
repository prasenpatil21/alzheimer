<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Education Booster 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content' ); ?>>
    <div class="post-content-inner">
        <?php if( has_post_thumbnail() ): ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail( 'education-booster-1200-850' ); ?>
            </div>
        <?php endif; ?>
        <div class="post-text">
        	<?php
                # Prints out the contents of this post after applying filters.
    			the_content();
    			wp_link_pages( array(
    				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'education-booster' ),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
    			) );
        	?>
        </div>
        <?php educationbooster_entry_footer(); ?>
    </div>
</article>