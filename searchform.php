<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>" autocomplete="off">
	<div>
		<label class="screen-reader-text" for="s">Search for:</label>
		<input type="text" value="<?php the_search_query(); ?>" placeholder="Search..." name="s" id="s" onkeyup="showResult(this.value)">
		<input type="image" alt="Search" src="<?php bloginfo( 'template_url' ); ?>/img/search-label.png" id="search-label"/>
	</div>
	<div id="ajax-livesearch" style="display: none;"></div>
</form>