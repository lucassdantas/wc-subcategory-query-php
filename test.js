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
