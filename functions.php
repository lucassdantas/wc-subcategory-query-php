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



//test
add_shortcode('product_slider_home_mobile', 'show_product_slides_home_mobile');
function show_product_slides_home_mobile(){
	$queryIndex = 0;
	$args = array(
		'parent' => 0
	);
	$terms = get_terms( 'product_cat', $args );
	
	if ( $terms ) {
		//tab-nav
		echo "<div class='div-overflow-hidden'>";
		echo '<div class="nav nav-tabs" id="tab_slider_mobile" role="tablist">';
		
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
			id='$slug-tab2-mobile' 
			data-bs-toggle='tab' 
			data-bs-target='#tab2-mobile-$slug' 
			role='tab' 
			aria-controls='tab2-mobile-$slug'
			aria-selected='$selected'>";

			echo $term->name;
			
			echo '</a>';
			$queryIndex ++;
		}
		echo '</div>';
		echo"</div>";
		
		//tabs_content
		echo '<div class="tab-content align-items-center" id="myTabContent-mobile">';
        
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
			id='tab2-mobile-$slug' 
			role='tabpanel' 
			aria-labelledby='$slug-tab2-mobile-' 
			tabindex='0'>";
            //carrossel
          	echo do_shortcode("[product category='$slug' per_page='-1']");
	
			echo "</div>"; //end single tab content
		} //endforeach
		echo '</div>'; //end tab content div
	}
}


add_shortcode('product_slider_home', 'show_product_slides_home');
function show_product_slides_home(){
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
          	$products = do_shortcode("[product category='$slug' per_page='-1']");
			$allProducts = preg_split("/<li\s*.*>\s*.*\s<\/li>/", $products);

			#beginSlides
			echo "<div class='carousel-container carousel-container$index'>
					<div class='inner-carousel inner-carousel$index'>";
				foreach ($allProducts as $index2=>$allProduct){
						echo $allProduct;
				}
				
				
				echo "<div class='nav$index nav'>
						  <button class='prev$index prev'><span class='material-symbols-outlined'>chevron_left</span></button>
						  <button class='next$index next'><span class='material-symbols-outlined'>chevron_right</span></button>
					</div>";//endnav
			echo"</div>";//endcarrouseinner
			echo"</div>";//endcarrouselcontainer
			#endSlides
			
		echo "<div class='btn-slides-div btn-slides-div$index'> </div>";
			echo "</div>"; //end single tab content
		} //endforeach
		
		echo '</div>'; //end tab content div
		//buttons navigator
		
	}
	echo'<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>';
?>
<script>
	
	//convert products into slide items
let wc = document.querySelectorAll("#home_produtos .woocommerce")
let navBtnDiv = document.querySelectorAll('.btn-slides-div')
let liList = []
let liArray = []
wc.forEach((item, i) => {
    liList[i] = item.querySelectorAll('li') 
	item.classList.add(`track`)
    item.classList.add(`track${i}`)
    
    item.classList.remove('woocommerce')
    item.innerHTML = ''
    liList[i].forEach((li, i2) => {
		let active = ''
		if(i2 === 0){active = 'active'}
        item.innerHTML += `<div class='item-of-carousel'><ul>${li.outerHTML}</ul></div>`
    })
	let slidesN = (liList[i].length+1)/4
	
	if(slidesN >= 1){
		for (let i3 = 0; i3<slidesN; i3++){
			let activeBtn = ''
			if(i3 === 0 ) activeBtn = 'nav-btn-active'
			navBtnDiv[i].innerHTML += `<div class='nav-slide-btn ${activeBtn}' id='nav-slide-btn-${i}-${i3}'></div>`
			navBtnDiv[i][i3] = navBtnDiv[i].querySelector(`#nav-slide-btn-${i}-${i3}`)
			console.log(navBtnDiv[i][i3])
		}	
	}
})


	//-----------SLIDER----------------------

let prev = []
let next = []
let carousel = []
let track = []
let width = [];
let index = [];
document.querySelectorAll('.carousel-container').forEach((carouselContainer, i) => {
    prev[i] = document.querySelector(`.prev${i}`);
    next[i] = document.querySelector(`.next${i}`);
	index[i] = 0;
	track[i] = document.querySelector(`.track${i}`);
	carousel[i] = carouselContainer;
    width[i] = carousel[i].offsetWidth
	
  window.addEventListener("resize", function () {
    width[i] = carousel[i].offsetWidth;
  });
  next[i].addEventListener("click", function (e) {
    carousel[i] = carouselContainer;
    width[i] = carousel[i].offsetWidth;
    
    e.preventDefault();
    index[i] = index[i] + 1;
    prev[i].classList.add("show");
    track[i].style.transform = "translateX(" + index[i] * -width[i] + "px)";
    if (track[i].offsetWidth - index[i] * width[i] < index[i] * width[i]) {
      next[i].classList.add("hide");
    }
  });
  prev[i].addEventListener("click", function () {
    index[i] = index[i] - 1;
    next[i].classList.remove("hide");
    if (index[i] === 0) {
      prev[i].classList.remove("show");
    }
    track[i].style.transform = "translateX(" + index[i] * -width[i] + "px)";
  });
	navBtnDiv[i].forEach((btn, iBtn) => {
		btn.addEventListener('click', (e) => {
			btn.forEach( b => {
				b.classList.remove('nav-btn-active')
			})
			
			e.target.classList.add('nav-btn-active')
			
			//if next
			if(iBtn > index[i]) {
				index[i] = index[i] + 1;
				prev[i].classList.add("show");
				track[i].style.transform = "translateX(" + index[i] * -width[i] + "px)";
				if (track[i].offsetWidth - index[i] * width[i] < index[i] * width[i]) {
				  next[i].classList.add("hide");
				}
			}
			if (iBtn < index[i]){
				index[i] = index[i] - 1;
				next[i].classList.remove("hide");
				if (index[i] === 0) {
				  prev[i].classList.remove("show");
				}
				track[i].style.transform = "translateX(" + index[i] * -width[i] + "px)";
			}
		})
	})
})

</script> 
<?php
}



//home slider
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
                        echo do_shortcode("[product category='$slug' per_page='4']");
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