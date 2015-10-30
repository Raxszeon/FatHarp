<?php get_header() ?>

<main>	
<h1><?php printf( __( 'Search Results for %s', 'fatharp' ), get_search_query() ); ?></h1>

<?php
global $wp_query;
$total_results = $wp_query->found_posts;
echo "We found ". $total_results . " matching things...";
?>

<?php
	
// Skapar en ny koppling för sökresultatet.	För att undvika krockar
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

$search = new WP_Query($search_query);
	
?>
<div id="content">
<?

// Listar sökresultatet
if( have_posts() ): while( have_posts() ): the_post(); 
	
// Tar fram eventuell thumbnail
$search_thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	
?>
	<article class="posts">
		<?= get_post_format();?>
		<?if(@$search_thumbnail) {?>
			<a href="<?php the_permalink(); ?>"><div class="searchresult_img" style="background-image: url('<?php echo $search_thumbnail;?>');"></div></a>
		<?}?>
			
		<h2 class="posts_headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<a href="<?php the_permalink(); ?>" class="post_date"><?php the_time('F jS, Y') ?></a>
		<p>
			<?php 
				 the_excerpt(); 
			?>
		</p>
		<?
		// Ifall woocommerce finns och det är en produkt visas även priset på denna.			
		if ( class_exists( 'WooCommerce' ) ) {
			$price = get_post_meta( get_the_ID(), '_regular_price', true);
		
			if(@$price) {
				$currency = get_woocommerce_currency_symbol();
				?>
				<p>
				<a href="<?php the_permalink(); ?>" class="post_price"><?=$currency;?><?=$price;?></a>
				</p>
			<?}	
		}
		?>
		
	</article>
<?php endwhile; 
	else: ?>
	
	<article>
		<p>
			Sorry, we can't find anything. Please try again.
		</p>
	</article>
	
<?php endif; ?>

<div class="pagination-box">
	<?php posts_pagination(); ?>
</div>

</div>


</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>