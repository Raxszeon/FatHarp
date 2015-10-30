<?php get_header() ?>

<main>
	<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
		<article>
			<div class="shop-breadcrumb">
			<a href="<?echo get_permalink( get_option('page_for_posts' ) );?>">NEWS</a> /</div>
			<h2 class="shop-title"><?php the_title(); ?></h2>
			<p><?php the_content(); ?></p>
			<?php the_post_thumbnail(); ?>
		</article>
	<?php endwhile; endif; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>