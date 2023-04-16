<script>
	
	//convert products into slide items
	let wc = document.querySelectorAll('#home_produtos .woocommerce')
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
	if (track[i].offsetWidth - (index[i]+1) * width[i] < index[i] * width[i]) {
		console.log('oi')
      next[i].classList.add('hide');
    }
	
  window.addEventListener('resize', function () {
    width[i] = carousel[i].offsetWidth;
  });
  next[i].addEventListener('click', function (e) {
    carousel[i] = carouselContainer;
    width[i] = carousel[i].offsetWidth;
    
    e.preventDefault();
    index[i] = index[i] + 1;
    prev[i].classList.add('show');
    track[i].style.transform = 'translateX(' + index[i] * -width[i] + 'px)';
    if (track[i].offsetWidth - index[i] * width[i] < index[i] * width[i]) {
      next[i].classList.add('hide');
    }
  });
  prev[i].addEventListener('click', function () {
    index[i] = index[i] - 1;
    next[i].classList.remove('hide');
    if (index[i] === 0) {
      prev[i].classList.remove('show');
    }
    track[i].style.transform = 'translateX(' + index[i] * -width[i] + 'px)';
  });
})
