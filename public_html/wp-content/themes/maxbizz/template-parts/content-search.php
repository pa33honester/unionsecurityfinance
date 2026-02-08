<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maxbizz
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-box'); ?>>
    <div class="post-inner">
        <div class="inner-post">
	        <div class="entry-header">

	            <?php the_title( '<h4 class="entry-title"><a class="title-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>

	        </div><!-- .entry-header -->

	        <div class="entry-summary the-excerpt">

	            <?php the_excerpt(); ?>

	        </div><!-- .entry-content -->
		</div>
		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php if( maxbizz_get_option( 'post_entry_meta' ) ) { maxbizz_post_meta(); } ?>
	        <a href="<?php the_permalink(); ?>" class="btn-details"><i class="ot-flaticon-trajectory"></i></a>
		</div><!-- .entry-meta -->
		<?php endif; ?>
    </div>
</article>
