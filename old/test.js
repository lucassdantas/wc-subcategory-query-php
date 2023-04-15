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



//---------------------- jquery slider ------------------------


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
        carouselWidth[i] = $(`.carousel-inner${i}`)[0].scrollWidth;
        cardWidth[i] = $(`.carousel-item${i}`).width();
        scrollPosition[i] = 0;
        $(`#carouselExampleControls${i} .carousel-control-next${i}`).on("click", function () {
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
        carouselWidth[i] = $(`.carousel-inner${i}`)[0].scrollWidth;
        cardWidth[i] = $(`.carousel-item${i}`).width();
        scrollPosition[i] = 0;
        $(`#carouselExampleControls${i} .carousel-control-prev${i}`).on("click", function () {
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
	


  



  
/* ORIGINAL

var multipleCardCarousel = document.querySelector(
    "#carouselExampleControls"
  );
  if (window.matchMedia("(min-width: 768px)").matches) {
    var carousel = new bootstrap.Carousel(multipleCardCarousel, {
      interval: false,
    });
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
  }
