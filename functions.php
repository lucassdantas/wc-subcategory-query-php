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
	$queryIndex = 0;
	$args = array(
		'parent' => 0
	);
	$terms = get_terms( 'product_cat', $args );
	
	if ( $terms ) {
		//tab-nav
		echo '<div class="nav nav-tabs justify-content-center" id="tab_slider" role="tablist">';
		//print single tabs of patern categories
		foreach ( array_reverse($terms) as $term ) {
			//pre class configuration
			$activeClass = '';
			$selected = 'false';
			if($queryIndex === 0) {
				$activeClass = 'active';
				$selected = 'true';
			}
			$slug = $term->slug;
			//tabs printing
			echo "<a class='nav-link $activeClass' 
			id='$slug-tab2' 
			data-bs-toggle='tab' 
			data-bs-target='#tab2-$slug' 
			role='tab' 
			aria-controls='tab2-$slug'
			aria-selected='$selected'>";
			
			#echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $slug . '">';
			echo $term->name;
			#echo '</a>';
			echo '</a>';
			$queryIndex ++;
		}
		echo '</div>';
		
		//tabs_content
		echo '<div class="tab-content align-items-center" id="myTabContent">';
		$queryIndex = 0;
        
		foreach ( array_reverse($terms) as $term ) {
			$activeClass = '';
            $activeClass02 = '';
			$show = '';
            $queryIndex02 = 0;
            $ariaCurrent = '';
			if($queryIndex === 0){
				$activeClass = 'active';
				$show = 'show';
			}
			$slug = $term->slug;
			
			//printing
			echo "<div class='tab-pane $show $activeClass'
			id='tab2-$slug' 
			role='tabpanel' 
			aria-labelledby='$slug-tab2' 
			tabindex='0'>";
            //carrossel
            echo "
            <div id='slider-$slug' class='carousel slide'>
                <div class='carousel-indicators'>
                    ";
                    $queryIndex02 = 0;


                    foreach($term as $quantity){
                        $ariaCurrent = '';
                        $activeClass02 = '';
                        if($queryIndex02 === 0) {
                            $activeClass02 = 'active';
                            $ariaCurrent = "aria-current='true'";
                        }
                        echo "<button type='button' data-bs-target='slider-$slug' data-bs-slide-to='$queryIndex02' class='$activeClass02' $ariaCurrent aria-label='slide $queryIndex02'></button>";
                        $queryIndex02++;
                    }
					$queryIndex02 = 0;
                        //close carousel indicator tag
                        echo " </div>  
                        <div class='carousel-inner'>";
                    foreach ($term as $quantity) {
						$activeClass02 = '';
                        if($queryIndex02 === 0) {
                            $activeClass02 = 'active';
                            $ariaCurrent = "aria-current='true'";
                        }
                        echo "<div class='carousel-item $activeClass02'>";
                        echo do_shortcode("[product category='$slug' per_page='12']");
                        echo "</div>";
                    
                        $queryIndex02++;
                    }
                    //end carrossel inner
                    echo "
                </div>
                <button class='carousel-control-prev' type='button' data-bs-target='#slider-$slug' data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Previous</span>
                </button>
                <button class='carousel-control-next' type='button' data-bs-target='#slider-$slug' data-bs-slide='next'>
                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Next</span>
                </button>
            </div>"; //endcarrossel
			echo '</div>'; //end single tab content
			$queryIndex ++;
		}
		echo '</div>';
	}
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
		$terms_html[] = "
		<div class='subcategory-div d-flex text-center justify-content-center align-items-center'> 
			<a href='".esc_url( $term_link )."' rel='tag' class='d-flex flex-column subcategory-title $term->slug'>
				<img class='megamenu-images' src='$image_url' alt='product-image'>".
				$term->name."'
			</a>
		</div>";
	}
	return implode( ' ', $terms_html );
}

add_shortcode('print_categories', 'woocommerce_product_category');

//tab de categoria pai com filho
function woocommerce_product_category( $args = array() ) {
	$queryIndex = 0;
	$args = array(
		'parent' => 0
	);
	$terms = get_terms( 'product_cat', $args );
	
	if ( $terms ) {
		echo '<div class="d-flex align-items-start tabs-megamenu">';
		//tab-nav
		echo '<div class="nav flex-column me-3 text-left nav-tabs" id="v-tab" role="tablist" aria-orientation="vertical">';
		echo "<h2>Produtos</h2>";
		//print single tabs of patern categories
		foreach ( array_reverse($terms) as $term ) {
			//pre class configuration
			$activeClass = '';
			$selected = 'false';
			if($queryIndex === 0) {
				$activeClass = 'active';
				$selected = 'true';
			}
			$slug = $term->slug;
			//tabs printing
			echo "<a class='nav-link $activeClass' 
			id='$slug-tab' 
			data-bs-toggle='tab' 
			data-bs-target='#tab-$slug' 
			role='tab' 
			aria-controls='tab-$slug'
			aria-selected='$selected'>";
			
			#echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $slug . '">';
			echo $term->name;
			#echo '</a>';
			echo '</a>';
			$queryIndex ++;
		}
		echo '</div>';
		
		//tabs_content
		echo '<div class="tab-content align-items-center" id="myTabContent">';
		$queryIndex = 0;
		foreach ( array_reverse($terms) as $term ) {
			$activeClass = '';
			$show = '';
			if($queryIndex === 0){
				$activeClass = 'active';
				$show = 'show';
			}
			$slug = $term->slug;
			
			//printing
			echo "<div class='tab-pane $show $activeClass'
			id='tab-$slug' 
			role='tabpanel' 
			aria-labelledby='$slug-tab' 
			tabindex='0'>";

				echo woocommerce_get_product_category_of_subcategories($slug);
			echo '</div>';
			$queryIndex ++;
		}
		echo '</div>';
		echo '</div>';
	}
}