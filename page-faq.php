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
	if($utvald_toppbild) {?>
	<div id="head_img" style="background-image: url('<?php echo $utvald_toppbild;?>');">
		<h1 class="rubrik"><?php the_title(); ?></h1>
		<?
		// Kontrollerar om titel finns, skriver isåfall ut som underrubrik
		if($title) {
			echo '<span class="underrubrik">'.$title.'</span>';
			}
			
		// Kontrollerar om Caption finns, skriver isåfall ut detta som Copyrightlänk
		if($caption) {
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

// ---- FAQ ÄR EN SPECIALSIDA OCH DÄRFÖR HÄMTAR DEN ÄVEN HÄR IN CUSTOM POST TYPE
	$args = array( 
	'post_type' => 'faq', 
	'orderby' => 'date',
	'order'   => 'ASC',
	'posts_per_page' => 20 );
	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) : $loop->the_post();?>
	  <h3><? the_title(); ?></h3>
	  <p><? the_content(); ?></p>
<? endwhile; 
// ---- SLUT PÅ CUSTOM POST TYPE	
?>

</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>