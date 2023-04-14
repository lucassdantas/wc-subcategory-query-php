//let wc = document.querySelectorAll("#myTabContent .woocommerce")
//let liList = []
//let liArray = []
wc.forEach((item, i) => {
    liList[i] = item.querySelectorAll('li') 
    item.classList.add('carousel-inner')
    item.classList.remove('woocommerce')
    item.innerHTML = ''
    liList[i].forEach(li => {
        item.innerHTML += `<div class='carousel-item'${li.outerHTML}</div>`
    })
})

