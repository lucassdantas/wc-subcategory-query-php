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

/*removo imagem da categoria de produtos na pag de produtos*/
.img_product_category img{
	display:none!important;
	visibility:hidden!important;
}



/*oculto span no titulo dos produtos*/
.product_weight{
	display:none;
	visibility:hidden;
}

/*animacao texto em slide para esquerda*/
.slider {
  height: 60px;
  position: relative;
  width: 100%;

  display: grid;
  place-items: center;
  overflow: hidden;
}
.slider::before,
.slider::after{
  position:absolute;
  content:'';
  height:100%;width:25%;
  z-index:5;pointer-events:none;
}
.slider::before{
  left:0;
  top:0;
}
.slider::after{
  right:0;
  top:0;
  transform:rotateZ(180deg);
}


.slide-track2 {
  width: calc(190px * 18);
  display: flex;
  animation: scroll2 15s linear infinite;
  justify-content: center;
}

.slide {
  width: 240px;
  height: 60px;

  display: grid;
  place-items: center;
  transition:0.5s;
  cursor:pointer;
}


@keyframes scroll2 {
  0% {
    transform: translateX(0px);
  }
  100% {
    transform: translateX(calc(-150px * 5));
  }
}

@media screen and (max-width: 768px) {

  .slide-track2 {
    width: calc(170px * 15);
  }

  .slide {
    width: 170px;
  }

  @keyframes scroll {
    0% {
      transform: translateX(0px);
    }
    100% {
      transform: translateX(calc(-80px * 10));
    }
  }

  @keyframes scroll2 {
    0% {
      transform: translateX(0px);
    }
    100% {
      transform: translateX(calc(-80px * 5));
    }
  }
}

/*----TEXTO ROTATIVO ----*/
/*logo no slider com movimento h*/
.slider-logo{
		width:25px;
	}

/*texto sublinhado*/
.underline{
	border-bottom:2px solid #000;
}

/*---- STICK HEADER ----*/
/*elementos que continuam brancos apos o stick header*/
.not_stick_black{
	color:#fff
}
.black_sticky, .black_sticky .ekit-menu-nav-link{
	color:#fff;
}

/*cores do cabecalho transparente em preto quando estiver ativo*/
 .ekit-sticky--effects *:not(.not_stick_black, .not_stick_black *) {
	color:#000!important;
}

.ekit-sticky--effects .black_sticky{
	color:#000!important;
}


/*----PRODUTOS MEGAMENU ----*/
/*oculto cores*/

#megamenu_produtos .swatchly-type-color, 

/*oculto peso com excecao dos ativos*/
#megamenu_produtos .swatchly-swatch,

/*oculto parcelas e precos*/
#megamenu_produtos .price, #megamenu_produtos .fswp_installments_price{
	display:none;
	visibility:hidden;
}

/*exibo titulo do span no produto*/
#megamenu_produtos .product_weight{
	display:block;
	visibility:visible;
	color:#8D8D8D;
}

/*retiro marca abaixo dos produtos*/
#megamenu_produtos .woocommerce-loop-product__buttons{
	display:none;
	visibility:hidden;
}

/*---CATEGORIAS MEGAMENU---*/


#megamenu_produtos .nav-tabs h2{
	font-weight:700;
	font-size:22px;
	line-height:26px;
	color:#2d2d2d;
	margin-bottom:24px;
	
}
#megamenu_produtos .subcategory-title{
	font-weight:600;
	line-height:16px;
	font-size:14px;
	margin-top:10px!important;
}
#megamenu_produtos a{
	font-family:Inter;
	color:#2D2D2D;
	
	
}
#megamenu_produtos .nav-link{
	font-size:16px;
	font-weight:500;
	line-height:19px;
	opacity:0.4;
	margin:12px 0;
	padding:0;
	
	
}
#megamenu_produtos .nav-tabs .active {
	border:0;
	margin:6px 0 0 0;
	border-bottom: 2px solid #000;
	opacity:1!important;
	
}
#megamenu_produtos a:hover{
	cursor:pointer;
}
#megamenu_produtos .subcategory-div{
	width:25%;
	margin-right:16px;
}
/*tamanho das imgs*/
	#megamenu_produtos .megamenu-images{
		width:100%;
		height:auto;
		margin-bottom:10px;
					background-color:#fafafa;
		border-radius:8px;
		padding:15px 18px 0;
		object-fit:cover;
		margin-right:16px;
	}
/*display flex nas tabs ativas*/
#megamenu_produtos .tab-content .show{
	display:flex!important;
}

#megamenu_produtos .tab-content{
	margin-left:80px;
	width:70%;
}




/*----PRODUTOS HOME ----*/
/*produtos com texto centralizado na nos produtos home*/
.att_produtos {
	text-align:center;
}


/*Margem das abas do slide na home*/
#home_produtos .eael-tabs-nav{
 margin-left: 25%;
 margin-right: 25%;
}

/*atributos dos produtos home*/
#home_produtos .swatchly-type-color *, #arquivos_produtos .swatchly-type-color *{
	min-width:12px;
	min-height:12px;
}
/*oculto tipo de texto label nos produtos*/
#home_produtos .swatchly-type-label, #arquivos_produtos .swatchly-type-label{
	display:none;
	visibility:hidden;
}

#produtos_relacionados .swatchly-type-color *, #arquivos_produtos .swatchly-type-color *{
	min-width:12px;
	min-height:12px;
}

#produtos_relacionados .swatchly-type-label, #arquivos_produtos .swatchly-type-label{
	display:none;
	visibility:hidden;
}


/*reseto zindex do filtro de precos na pag de produtos*/
.ui-slider-handle {
	z-index:0!important;
}

/*--------RESPONSIVIDADE-------*/
	/*ajusto responsividade do megamenu*/
	@media screen and (min-width: 766px) and (max-width: 1024px){
		.ekit_menu_responsive_mobile .elementskit-dropdown-menu-full_width.top_position .elementskit-megamenu-panel{
		left:0;
		right:0;
		margin-left:0;
		margin-right:0;
			top:45px;
		}
	}

@media (max-width:768px){
	
/*scroll horizontal nos produtos da home mobile*/
	#home_produtos{
		overflow-x:auto!important;
	}
	#home_produtos .elementor-container{
		overflow-x:auto;
		display:flex;
		flex-wrap:nowrap;
	}
	#home_produtos ul{
		flex-wrap:nowrap;
	}
	#home_produtos .products{
		display:flex;
		width:260%!important;
	}
	#home_produtos .eael-tabs-nav{
		overflow-x:auto;
	}
	
	/*reseto a margem das abas*/
	#home_produtos .eael-tabs-nav{
		margin:0px;
	}
	#home_produtos .eael-tabs-nav ul li:nth-child(2) span{
		width:140px!important;
	}
	
	/*scroll horizontal nas categorias mobile*/
 .category_section{
				overflow-x:auto!important;

	}
	.category_section .elementor-container{
		overflow-x:auto;
		flex-direction:row;
		flex-wrap:nowrap;
		width:280%;
	}
	/* Hide scrollbar for Chrome, Safari and Opera */
.category_section .elementor-container::-webkit-scrollbar, .category_section::-webkit-scrollbar, #home_produtos::-webkit-scrollbar, #home_produtos .elementor-container::-webkit-scrollbar, #home_produtos .eael-tabs-nav::-webkit-scrollbar  {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.category_section .elementor-container, .category_section::-webkit-scrollbar, #home_produtos::-webkit-scrollbar, #home_produtos .elementor-container::-webkit-scrollbar, .eael-tab-nav, #home_produtos .eael-tabs-nav::-webkit-scrollbar  {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
	
	/*texto doo slide*/ 
	.slide{
		font-size:13px;
	}
	.slide img{
		width:13px;
		height:19px;
	}
	
	
	/*sessao de imagens abaixo do video na vertical*/
	#phone_image_box_section .elementor-image-box-wrapper{
		display:flex;
		text-align:left;
	}
	#phone_image_box_section .elementor-image-box-wrapper .elementor-image-box-img{
	}
	#phone_image_box_section .elementor-image-box-title{
		margin:0;

	}
	#phone_image_box_section .elementor-image-box-content{
		margin-left:17px;
	}
}


	/*customização do botão 'ordenação' na pagina de produtos*/

.orderby{
		background-color: white;
    
    color:#1A1E26;
    border-color: #F4F4F4;
    border-radius: 50px;
    width: 195px;
		margin-bottom:32px;
}
	/*retira a paginação padrão da pagina de produtos*/
.woocommerce-pagination{display:none;}

	/*retira o label de quantidade da pagina de produto*/
#add_cart .wl-quantity-wrap {margin-left:-70px;}



	/*largura dos campos de finalização de compra*/
#billing_city_field{
    width: 100%;
}
#billing_neighborhood_field{
    width: 100%;
}

	/*margin do campo de endereço na pagina de finalização de compra*/
#billing_address_2_field{
   margin-top:  7%;
}