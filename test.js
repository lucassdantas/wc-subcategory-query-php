let wc = document.querySelectorAll('.woocommerce .products')
let liList = []
wc.forEach((item, i) => {
    liList[i] = item.querySelectorAll('li') 
})