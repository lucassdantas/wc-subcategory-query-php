let wc = document.querySelectorAll("#myTabContent .woocommerce")
let liList = []
let liArray = []
wc.forEach((item, i) => {
    liList[i] = item.querySelectorAll('li') 
    item.classList.add('carousel-inner')
    item.classList.remove('woocommerce')
    item.innerHTML = ''
    liList[i].forEach(li => {
        item.innerHTML += `<div class='carousel-item'><ul>${li.outerHTML}</ul></div>`
    })
})



//---------------------- jquery slider ------------------------


let AllmultipleCardCarousel = document.querySelectorAll(
    ".carouselExampleControls"
  );

  if (window.matchMedia("(min-width: 768px)").matches) {
    let carouselWidth = $(".carousel-inner")[0].scrollWidth;
    let cardWidth = $(".carousel-item").width();
    let scrollPosition = []
    let prevBtn = document.querySelectorAll('.carousel-control-prev')
    let nextBtn = document.querySelectorAll('.carousel-control-next')
    nextBtn.forEach((btn,index) => {
         scrollPosition[index] = 0;
        $(`#carouselExampleControls${index} .carousel-control-next`).on("click", function () {
            console.log(btn)
            if (scrollPosition[index] < carouselWidth - cardWidth * 4) {
              scrollPosition[index] += cardWidth;
              $(`#carouselExampleControls${index} .carousel-inner`).animate(
                { scrollLeft: scrollPosition[index] },
                600
              );
            }
        });
    })
    prevBtn.forEach((btn, index) => {
        scrollPosition[index] = 0;
        $(`#carouselExampleControls${index} .carousel-control-prev`).on("click", function () {
            console.log(btn)
            if (scrollPosition[index] > 0) {
              scrollPosition[index] -= cardWidth;
              $(`#carouselExampleControls${index} .carousel-inner`).animate(
                { scrollLeft: scrollPosition[index] },
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
