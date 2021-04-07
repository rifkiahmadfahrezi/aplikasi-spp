
// live search 
const searchBox = document.querySelector('#cari-pembayaran')
let tbody = document.querySelector('.table-responsive')
searchBox.addEventListener('input', function() {
	const ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			let response = ajax.responseText;
			tbody.innerHTML = response
		}
	};
	ajax.open('GET', `src/search-payment.php?keyword=${this.value}`, true);
	ajax.send();
})