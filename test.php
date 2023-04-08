<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );


add_shortcode('product_slider', 'show_product_slides');

function show_product_slides(){
$products = wc_get_products( array( 'status' => 'publish', 'limit' => -1 ) );

echo "<pre>"; print_r($products); echo "</pre>";
	echo "<br> <p>------------------------------------</p>";
	#print_r( $products[0]['WP_Product_Variable']);
	/*
foreach ( $products as $product ){
	
    echo  $product->get_status();  // Product status
	echo "<br>";
    echo  $product->get_type();  // Product type
	echo "<br>";
    echo  $product->get_id();    // Product ID
	echo "<br>";
    echo  $product->get_title(); // Product title
	echo "<br>";
    echo  $product->get_slug(); // Product slug
	echo "<br>";
    echo  $product->get_price(); // Product price
	echo "<br>";
    echo  $product->get_catalog_visibility(); // Product visibility
	echo "<br>";
    echo  $product->get_stock_status(); // Product stock status
    // product date information
    echo $product->get_date_created()->date('Y-m-d H:i:s');
    echo $product->get_date_modified()->date('Y-m-d H:i:s');
}*/
	
}

//subcategories function
function woocommerce_get_product_category_of_subcategories( $category_slug ){
	$terms_html = array();
	$taxonomy = 'product_cat';

	$parent = get_term_by( 'slug', $category_slug, $taxonomy );

	$children_ids = get_term_children( $parent->term_id, $taxonomy );


	foreach($children_ids as $children_id){
		$term = get_term( $children_id, $taxonomy ); 
		$term_link = get_term_link( $term, $taxonomy ); 
		$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
		$image_url = wp_get_attachment_url( $thumbnail_id );
		if ( is_wp_error( $term_link ) ) $term_link = '';
		$terms_html[] = '<div class="subcategory-div d-flex text-center justify-content-center align-items-center"> <a href="' .
			esc_url( $term_link ) . 
			'" rel="tag" class="d-flex flex-column ' . 
			$term->slug . '">' .
			"<img class='megamenu-images' src='$image_url' alt='product-image'>".
			$term->name . 
			'</a></div>';
	}
	return implode( ' ', $terms_html );
}

add_shortcode('print_categories', 'woocommerce_product_category');
function woocommerce_product_category( $args = array() ) {
	$queryIndex = 0;
	$args = array(
		'parent' => 0
	);
	$terms = get_terms( 'product_cat', $args );
	if ( $terms ) {
		echo '<div class="d-flex align-items-start">';
		echo '<div class="nav flex-column nav-tabs" id="myTab" role="tablist" aria-orientation="vertical">';
		
		//print categories
		foreach ( array_reverse($terms) as $term ) {
			$activeClass = '';
			$selected = 'false';
			if($queryIndex === 0) {
			#	$activeClass = 'active';
			#	$selected = 'true';
			}
			$slug = $term->slug;
			
			echo "<li class='nav-item $activeClass' role='presentation'>";
			echo '<button class="nav-link" id="'.$slug.'" data-bs-toggle="tab" data-bs-target="#'.$slug.'-tab-pane" type="button" role="tab" aria-controls="'.$slug.'-tab-pane" aria-selected="'.$selected.'">';
			echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $slug . '">';
			echo $term->name;
			echo '</a>';
			echo '</button>';
			echo '</li>';
			$queryIndex ++;
		}
		echo '</div>';
	
		echo '<div class="tab-content" id="myTabContent">';
		$queryIndex = 0;
		foreach ( array_reverse($terms) as $term ) {
			$activeClass = '';
			$show = '';
			if($queryIndex === 0){
			#	$activeClass = 'active';
			#	$show = 'show';
			}
			$slug = $term->slug;
			echo '<div class="tab-pane '.$show.' '.$activeClass.'" id="'.$slug.'-tab-pane" role="tabpanel" aria-labelledby="'.$slug.'-tab" tabindex="0" style="display:flex;">';

				echo woocommerce_get_product_category_of_subcategories($slug);
			echo '</div>';
			$queryIndex ++;
		}
		echo '</div>';
		echo '</div>';
	}
}