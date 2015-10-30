<aside id="sidebar">
	
	
	<?php
		
	 /*
	Istället för att kundvagnen skall läggas till 
	som en widget så skrivs widgeten ut här automatiskt.
	(Förutsatt att WooCoomerce finns installerad)
	*/	
		
	if ( class_exists( 'WooCommerce' ) ) {
	?>
	<div class="sidebar-widget kundvagn-widget">
			<div id="woocommerce_widget_cart-3" class="woocommerce widget_shopping_cart">
				<h3>Your Cart</h3>
				<div class="hide_cart_widget_if_empty"><div class="widget_shopping_cart_content">
					<? woocommerce_mini_cart( $args );?>
				</div>
		</div></div>	
	</div>	
	<? } ?>
	
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1')) ?>
	</div>
		
		<a href="http://www.seydel1847.de/"><img src="<?=get_template_directory_uri();?>/img/aside-seydel.jpg" alt="Seydel" class="sidebar-img"></a>
		<a href="http://www.seydel1847.de/"><img src="<?=get_template_directory_uri();?>/img/aside-1847.jpg" alt="1847" class="sidebar-img"></a>		
	
	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-2')) ?>
	</div>
	
</aside>
