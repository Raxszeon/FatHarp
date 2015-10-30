<?php get_header() ?>

<?php 
	
	// ------- VISAR VALD SIDA -----------------------------------------------------
	if( have_posts() ): while( have_posts() ): the_post(); ?>
	
<?php 

	$utvald_toppbild = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	$title = get_post(get_post_thumbnail_id())->post_title;
	$caption = get_post(get_post_thumbnail_id())->post_excerpt; 

?>

<?php
	// ------- VISAR OM MAN HAR VALT EN TOPPBILD -----------------------------------
	if(@$utvald_toppbild) {?>
	<div id="head_img" style="background-image: url('<?php echo $utvald_toppbild;?>');">
		<h1 class="rubrik"><?php the_title(); ?></h1>
		<?
		// Kontrollerar om titel finns, skriver isåfall ut som underrubrik
		if(@$title) {
			echo '<span class="underrubrik">'.$title.'</span>';
			}
			
		// Kontrollerar om Caption finns, skriver isåfall ut detta som Copyrightlänk
		if(@$caption) {
			echo '<div class="copyright"><a href="http://'.$caption.'" target="_blank">&copy; '.$caption.'</a></div>';
			}
		?>
	</div>
<? } ?>
<main>	
		<?
		if(!$utvald_toppbild) {?>
			<h2><?php the_title(); ?></h2>
		<?}?>
		<p><?php the_content(); ?></p>

<?php 
	endwhile; 
	endif; 
	 
	// ------- VISAR NYHETER PÅ FRAMSIDAN -----------------------------------------------------
	if ( is_front_page() ) { 
		while ( have_posts() ) :  the_post(); 
		$args = array( 'numberposts' => 2 );
		$lastposts = get_posts( $args );
		foreach($lastposts as $post) : setup_postdata($post); ?>

		<article class="posts">
			<h2 class="posts_headline"><?php the_title(); ?></h2>
			<a href="<?php the_permalink(); ?>" class="post_date"><?php the_time('F jS, Y') ?></a>
			<p>
				<?php the_content(); ?>
			</p>
		</article>

<?php 
	endforeach;
		echo "<a class=\"pagination-box\" href=\"posts/\">Show all posts &raquo;</a>";
	endwhile; 
}
?>
</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>