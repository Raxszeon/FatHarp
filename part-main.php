<div id="head_img" style="background-image: url('<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2015/10/front_news.jpg');">
	<h1 class="rubrik">NEWS</h1>
	<span class="underrubrik">FROM FATHARP.com</span>
</div>

<main>	
<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<article class="posts">
		<h2 class="posts_headline"><?php the_title(); ?></h2>
		<a href="<?php the_permalink(); ?>" class="post_date"><?php the_time('F jS, Y') ?></a>
		<p>
			<?php the_content(); ?>
		</p>
		<?php edit_post_link('EDIT POST', '<p>', '</p>'); ?>
	</article>
<?php endwhile; 
	else: ?>
	
	<article>
		<h2>No news to show</h2>
		<p>
			We can't find anything new to show. Sorry.
		</p>
	</article>
	
<?php endif; ?>

<div class="pagination-box">
	<?php posts_pagination(); ?>
</div>


</main>

<?php get_sidebar(); ?>
