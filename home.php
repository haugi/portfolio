<?php
/*
Template: Portfolio
Author: Markus Haug

Version: 1.0

*/
?>

<?php get_header(); ?>
 
<div id="posts">
<?php
$current_post_count = 0;

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		$current_post_count++;
		$sum_posts_shown = $wp_query->post_count;
?>
		<div id="post-item">
			<a class="post-item-link" href="<?php the_permalink(); ?>">
			<?php if (has_post_thumbnail()) { ?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail('home'); ?>
				<div class="post-title"><span><?php the_title() ?></span></div>
			</div>
			<?php } else { ?>
			<div class="no-thumb">
				<div class="post-title"><span><?php the_title() ?></span></div>
			</div>
			<?php } ?>
			</a>
			
			<div class="post-content"><?php the_content('') ?></div>
			<?php //echo get_the_excerpt() ?>
			<?php //echo the_excerpt_max_charlength(20) ?>
			<!--<div class="date"><?php the_time('d. F Y - H:i') ?></div>-->
			<!--<div class="author"><?php the_author() ?></div>-->
		</div>
		<?php post_seperator($sum_posts_shown, $current_post_count) ?>
<?php
	} 
}
?>
</div>

<?php get_sidebar(); ?>

<div class="clear"></div>

<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>
<?php get_footer(); ?>