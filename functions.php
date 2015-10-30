<?php
/* Functions for:
 * @theme FatHarp
 */

$version = '1.9';

// Kortar ner excertp inläggen ...........................................................................
function my_excerpt_length( $length ) {
	return 13;
	}
add_filter('excerpt_length', 'my_excerpt_length');


// Lägger till Styles och Script-taggar ..................................................................
function fatharp_add_styles_scripts( ) {
	wp_enqueue_script( 'main-js', get_template_directory_uri().'/js/main.js');
	wp_enqueue_script( 'ajax-livesearch', get_template_directory_uri().'/js/ajax-livesearch.js');
	wp_enqueue_style( 'fatharp_style', get_template_directory_uri().'/css/main.css', array(), $version );
	wp_enqueue_style( 'shop_style', get_template_directory_uri().'/css/style_shop.css', array(), $version );
	}
	add_action('wp_enqueue_scripts', 'fatharp_add_styles_scripts');


// Script som ska läggas i footern
function fatharp_add_to_bottom() {
	wp_enqueue_script( 'main-js-bottom', get_template_directory_uri().'/js/main-bottom.js');
	}		
	add_action( 'wp_footer', 'fatharp_add_to_bottom' );



// Lägger till themesupport ............................................................................
function fatharp_add_theme_support() {
	$custom_header_settings = array(
		'default-image' => get_template_directory_uri() . '/img/logotype.jpg',
		'uploads'       => true,
		);
	
	add_theme_support('custom-header', $custom_header_settings);
	add_theme_support('post-thumbnails');
	add_theme_support('post-formats', array('aside', 'video'));
	
	register_nav_menus(array(
		'main_menu' => 'Main Menu'
		));	
	
}
	
add_action('init', 'fatharp_add_theme_support');




// Raderar menyer som ej kommer att användas just nu, för att tydligöra adminen
function remove_menus(){
 
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'tools.php' );                  //Tools
	//  remove_menu_page( 'themes.php' );                 //Appearance
	//  remove_menu_page( 'plugins.php' );                //Plugins
	//  remove_menu_page( 'users.php' );                  //Users
	//  remove_menu_page( 'options-general.php' );        //Settings

}
add_action( 'admin_menu', 'remove_menus' );


// Aktiverar swidgetboxar i sidebaren ...........................................................................

if (function_exists('register_sidebar'))
{
    register_sidebar(array(
        'name' => __('Sidebar  1', 'fatharp'),
        'description' => __('Sidebar del 1. Visas längst upp i sidomenyn..', 'fatharp'),
        'id' => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'name' => __('Sidebar 2', 'fatharp'),
        'description' => __('Sidebar del 2. Visas längst ner i sidomenyn.', 'fatharp'),
        'id' => 'sidebar-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
          
}

add_filter('widget_text', 'do_shortcode'); 		// Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); 


// Lägger till Custom post-type...........................................................................
// Skapar fliken Persons så att man kan lägga till detta i ADMIN

function fatharp_faq_post_types() {
	register_post_type('faq', array(
		'public' => true,
		'labels' => array(
			'name' => 'FAQ'
			),
		'hierarchical' => true,
		'supports' => array (
			'title', 'page-attributes', 'editor' )
		) );	
	}

add_action('init', 'fatharp_faq_post_types');


// Skapar Paginationen för Posts  ......................................................................
function posts_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
	}

add_action('init', 'posts_pagination');




//Rättar till diverse saker i shopen............................................................................

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 ); /// Tar bort omdömmen

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 ); // Tar bort antal sökresultat
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 ); // Tar bort beskrivning, för att använda content istället.

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 8;' ), 20 ); // Visar 8 produkter per sida...

function wcs_woo_remove_reviews_tab($tabs) { // Tar bort Reviews från woocommerce 
	 unset($tabs['reviews']);
	 return $tabs;
	}


//---------------------------------------------------------------------------------------------------------------
// LÄGGER TILL WYSIWYG FÖR DESCRIPTION PÅ KATEGORIER.............................................................
// Credit to: http://www.wpmusketeer.com/add-a-wysiwyg-field-to-woocommerce-product-category-page/

// Add term page
add_action( 'product_cat_add_form_fields', 'wpm_taxonomy_add_new_meta_field', 10, 2 );
function wpm_taxonomy_add_new_meta_field() {
  // this will add the custom meta field to the add new term page
  ?>
  <div class="form-field">
    <label for="term_meta[custom_term_meta]"><?php _e( 'Details', 'wpm' ); ?></label>
    <textarea name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" rows="5" cols="40"></textarea>
    <p class="description"><?php _e( 'Vill du ha en presentation i samband med kategorin läggs denna här.','wpm' ); ?></p>
  </div>
 <?
}

// Edit term page
add_action( 'product_cat_edit_form_fields', 'wpm_taxonomy_edit_meta_field', 10, 2 );
function wpm_taxonomy_edit_meta_field($term) {

  $t_id = $term->term_id;
   $term_meta = get_option( "taxonomy_$t_id" );
  $content = $term_meta['custom_term_meta'] ? wp_kses_post( $term_meta['custom_term_meta'] ) : '';
  $settings = array( 'textarea_name' => 'term_meta[custom_term_meta]' );
  ?>
  <tr class="form-field">
  <th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Details', 'wpm' ); ?></label></th>
    <td>
      <?php wp_editor( $content, 'product_cat_details', $settings ); ?>
      <p class="description"><?php _e( 'Vill du ha en presentation i samband med kategorin läggs denna här.','wpm' ); ?></p>
    </td>
  </tr>
<?php
}

// Save extra taxonomy fields callback function
add_action( 'edited_product_cat', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_product_cat', 'save_taxonomy_custom_meta', 10, 2 );
function save_taxonomy_custom_meta( $term_id ) {
  if ( isset( $_POST['term_meta'] ) ) {
    $t_id = $term_id;
    $term_meta = get_option( "taxonomy_$t_id" );
    $cat_keys = array_keys( $_POST['term_meta'] );
    foreach ( $cat_keys as $key ) {
      if ( isset ( $_POST['term_meta'][$key] ) ) {
        $term_meta[$key] = wp_kses_post( stripslashes($_POST['term_meta'][$key]) );
      }
    }
    // Save the option array.
    update_option( "taxonomy_$t_id", $term_meta );
  }
}


// Display details on product category archive pages
add_action( 'woocommerce_archive_description', 'wpm_product_cat_archive_add_meta' ); //woocommerce_before_shop_loop
function wpm_product_cat_archive_add_meta() {
  $t_id = get_queried_object()->term_id;
  $term_meta = get_option( "taxonomy_$t_id" );
  $term_meta_content = $term_meta['custom_term_meta'];
  if ( $term_meta_content != '' ) {
    echo '<div class="woo-sc-box normal rounded full">';
      echo apply_filters( 'the_content', $term_meta_content );
    echo '</div>';
  } else {
	  echo "<br>";
  }
}

// ..../WYSIWYG..................................................................................................
//---------------------------------------------------------------------------------------------------------------



// Ta bort och ersätt "Add to Cart"-knappen med en knapp som visas "Read More" istället..........................
function remove_addtocart_button(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}

function replace_addtocart() {
	global $product;
	$link = $product -> get_permalink();
	echo do_shortcode('<a href="'.$link.'" class="button addtocartbutton">Read More</a>');
	}
	
add_action('init','remove_addtocart_button');
add_action('woocommerce_after_shop_loop_item','replace_addtocart');



// Deklararerar Woocommerce-support, Orka varning i adminen .......................................................
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}



// AJAX search....................................................................................................


function ajax_search(){
	$query_string = $_GET['q'];
	$s = new WP_Query(array( 's' => $query_string ));

	echo '<ul>';
	while($s->have_posts()){ 
		$s->the_post();
		
		// Hämtar Thumbnail.
		$search_thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID, $size = 'thumbnail' ) );

		// Startar raden 
		echo "<li>";

		// Kontrollerar ifall thumbnail finns till inlägget.
		if(@$search_thumbnail) {?>
			<a href="<?php the_permalink(); ?>"><div class="livesearch_thumb" style="background-image: url('<?php echo $search_thumbnail;?>');"></div></a>
		<? } ?>
		<a class="ajax_search_link" href="<?php the_permalink(); ?>"> - <?php the_title(); ?></a>
		<?php 
			
		// Ifall woocommerce finns och det är en produkt visas även priset på denna.			
		if ( class_exists( 'WooCommerce' ) ) {
			$price = get_post_meta( get_the_ID(), '_regular_price', true);
		
			if(@$price) {
				$currency = get_woocommerce_currency_symbol();
				?>
				<a href="<?php the_permalink(); ?>" class="ajax_search_price"><?=$currency;?><?=$price;?>:-</a>
			<?}	
		}
		
		echo "</li>"; 
	}
	echo '</ul>';
	wp_die();
}

add_action('wp_ajax_search', 'ajax_search');
add_action('wp_ajax_nopriv_search', 'ajax_search');



?>