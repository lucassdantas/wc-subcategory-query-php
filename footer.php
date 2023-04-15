<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-footer' );
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
?>

<?php wp_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/jquery-3.6.4.min.js"
  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
  crossorigin="anonymous"></script>
<script>
	//convert products into slide items
	let wc = document.querySelectorAll("#myTabContent .woocommerce")
let liList = []
let liArray = []
wc.forEach((item, i) => {
    liList[i] = item.querySelectorAll('li') 
    item.classList.add(`carousel-inner`)
    item.classList.add(`carousel-inner${i}`) 
    item.classList.remove('woocommerce')
    item.innerHTML = ''
    liList[i].forEach(li => {
        item.innerHTML += `<div class='carousel-item carousel-item${i}'><ul>${li.outerHTML}</ul></div>`
    })
})
	
	//-----------SLIDER----------------------
let AllmultipleCardCarousel = document.querySelectorAll(
    ".carouselExampleControls"
  );

  if (window.matchMedia("(min-width: 768px)").matches) {
    let carouselWidth = []
    let cardWidth = []
    let scrollPosition = []
    let prevBtn = document.querySelectorAll('.carousel-control-prev')
    let nextBtn = document.querySelectorAll('.carousel-control-next')
    nextBtn.forEach((btn,i) => {
        
        $(`#carouselExampleControls${i} .carousel-control-next${i}`).on("click", function () {
			carouselWidth[i] = $(`.carousel-inner${i}`)[0].scrollWidth;
			cardWidth[i] = $(`.carousel-item${i}`).width();
			scrollPosition[i] = 0;
            console.log(btn)
            console.log(scrollPosition[i])
            console.log(carouselWidth[i])
            if (scrollPosition[i] < carouselWidth[i] - cardWidth[i] * 4) {
              scrollPosition[i] += cardWidth[i];
              $(`#carouselExampleControls${i} .carousel-inner${i}`).animate(
                { scrollLeft: scrollPosition[i] },
                600
              );
            }
        });
    })
    prevBtn.forEach((btn, i) => {
        
        $(`#carouselExampleControls${i} .carousel-control-prev${i}`).on("click", function () {
			//carouselWidth[i] = $(`.carousel-inner${i}`)[0].scrollWidth;
			//cardWidth[i] = $(`.carousel-item${i}`).width();
			//scrollPosition[i] = 0;
            console.log(btn)
            if (scrollPosition[i] > 0) {
              scrollPosition[i] -= cardWidth[i];
              $(`#carouselExampleControls${i} .carousel-inner${i}`).animate(
                { scrollLeft: scrollPosition[i] },
                600
              );
            }
        });
    })
    } else {
        //$(multipleCardCarousel).addClass("slide");
    }
	
	
	
	
	
/*original
	var multipleCardCarousel = document.querySelector(
  "#carouselExampleControls"
);
if (window.matchMedia("(min-width: 768px)").matches) {
  var carouselWidth = $(".carousel-inner")[0].scrollWidth;
  var cardWidth = $(".carousel-item").width();
  var scrollPosition = 0;
  $("#carouselExampleControls .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
      scrollPosition += cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
  $("#carouselExampleControls .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
} else {
  $(multipleCardCarousel).addClass("slide");
}*/
</script>

</body>
</html>
