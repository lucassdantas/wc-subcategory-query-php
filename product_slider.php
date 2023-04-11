<?php
function show_product_slides(){
	$queryIndex = 0;
	$args = array(
		'parent' => 0
	);
	$terms = get_terms( 'product_cat', $args );
	
	if ( $terms ) {
		//tab-nav
		echo '<div class="nav  nav-tabs" id="v-tab" role="tablist">';
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
            <div id='slider-$term' class='carousel slide'>
                <div class='carousel-indicators'>
                    ";
                    foreach($term as $quantity){
                        $firstRollContent = '';
                        if($queryIndex02 === 0) {
                            $activeClass02 = 'active';
                            $ariaCurrent = "aria-current='true'";
                            $firstRollContent = "
                            </div>
                            <div class='carousel-inner'>" ;
                        }
                        echo "<button type='button' data-bs-target='slider-$term' data-bs-slide-to='$queryIndex02' class='$activeClass02' $ariaCurrent aria-label='slide $queryIndex02'></button>";
                        echo $firstRollContent;
                        echo "<div class='carousel-item $activeClass02'>";
                        echo do_shortcode("[product category='$slug' per_page='12']");
                        echo "</div>";
                    
                        $queryIndex02++;
                    }
                    $queryIndex02 = 0;
                    
                    
                    //end carrossel inner
                    echo "
                </div>
                <button class='carousel-control-prev' type='button' data-bs-target='#slider-$term' data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Previous</span>
                </button>
                <button class='carousel-control-next' type='button' data-bs-target='#slider-$term' data-bs-slide='next'>
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