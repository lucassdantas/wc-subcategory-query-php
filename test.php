<?php
function show_product_slides_test(){
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

        
		foreach ( array_reverse($terms) as $index=>$term ) {
			$activeClass = '';
			$show = '';
			$slug = $term->slug;
			
			if($index === 0){
				$activeClass = 'active';
				$show = 'show';
			}
			
			//printing
			echo "<div class='tab-pane $show $activeClass'
			id='tab2-$slug' 
			role='tabpanel' 
			aria-labelledby='$slug-tab2' 
			tabindex='0'>";
            //carrossel
          	$products = do_shortcode("[product category='$slug' per_page='4']");
			$allProducts = preg_split("/<li\s*.*>\s*.*\s<\/li>/", $products);

			#beginSlides
			echo "
				<div id='carouselExampleControls' class='carousel' data-bs-ride='carousel'>
    				<div class='carousel-inner'>";
					echo $index;
			echo"
						<div class='carousel-item active'>
                            <div class='card'>
                                <div class='img-wrapper'><img src='...' class='d-block w-100' alt='...'> </div>
                                <div class='card-body'>
                                    <h5 class='card-title'>Card title 1</h5>
                                    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                    <a href='#' class='btn btn-primary'>Go somewhere</a>
                                </div>
                            </div> 
                        </div>
						<div class='carousel-item'>
                            <div class='card'>
                                <div class='img-wrapper'><img src='...' class='d-block w-100' alt='...'> </div>
                                <div class='card-body'>
                                    <h5 class='card-title'>Card title 1</h5>
                                    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                    <a href='#' class='btn btn-primary'>Go somewhere</a>
                                </div>
                            </div> 
                        </div>
						<div class='carousel-item'>
                            <div class='card'>
                                <div class='img-wrapper'><img src='...' class='d-block w-100' alt='...'> </div>
                                <div class='card-body'>
                                    <h5 class='card-title'>Card title 1</h5>
                                    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                    <a href='#' class='btn btn-primary'>Go somewhere</a>
                                </div>
                            </div> 
                        </div>
						<div class='carousel-item'>
                            <div class='card'>
                                <div class='img-wrapper'><img src='...' class='d-block w-100' alt='...'> </div>
                                <div class='card-body'>
                                    <h5 class='card-title'>Card title 1</h5>
                                    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                    <a href='#' class='btn btn-primary'>Go somewhere</a>
                                </div>
                            </div> 
                        </div>
						<div class='carousel-item'>
                            <div class='card'>
                                <div class='img-wrapper'><img src='...' class='d-block w-100' alt='...'> </div>
                                <div class='card-body'>
                                    <h5 class='card-title'>Card title 1</h5>
                                    <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the
                                        card's content.</p>
                                    <a href='#' class='btn btn-primary'>Go somewhere</a>
                                </div>
                            </div> 
                        </div>";
					/*foreach ($allProducts as $index2=>$allProduct){
						if($index2 == 0){
							$activeClass02 = 'active';
						}
						echo "
						<div class='carousel-item $activeClass02'>";
						echo $allProduct;
						echo "</div>";
					}*/
			
			echo "</div>
			<button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='prev'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                        <span class='visually-hidden'>Previous</span>
                    </button>
                    <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='next'>
                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                        <span class='visually-hidden'>Next</span>
                    </button>
					
				</div>";
			#endSlides
			
		
			echo "</div>"; //end single tab content
		}
		echo '</div>';
	}
}