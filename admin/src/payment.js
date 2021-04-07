// month and date payment 
const datePayment = document.querySelector('#tgl-bayar')
const yearPayment = document.querySelector('input#tahun')

const date = new Date()

let currentDate =  String(date.getDate()).padStart(2,'0')
let currentMonth = String(date.getMonth() + 1).padStart(2,'0')
let currentYear = date.getFullYear()

// set input date value like current date
datePayment.value = `${currentYear}-${currentMonth}-${currentDate}`

const months = document.querySelectorAll('input[type=radio]')

let totalPayment = document.querySelector('input#total')
let pricePerMonth = document.querySelector('input#harga')

var selected = 0
months.forEach(month => {
	month.addEventListener('click', function() {
		this.parentElement.classList.toggle('selected')

		

		if (!this.parentElement.classList.contains('selected')) {
			this.checked = false
		}

		let monthHasSelected = month.parentElement.classList.contains('selected')

		if (monthHasSelected) {
			selected += 1
		}else{
			selected -= 1
		}

		// set total payment
		totalPayment.value = `${pricePerMonth.value * selected}`

	})
	
	
})




// serch nisn dropdown
const nisnInput = document.querySelector("#cari-nisn")
let nisnWrapper = document.querySelector('.list-nisn')
let nisn = document.querySelectorAll('.nisn-item')


nisnInput.addEventListener('input', function() {
	const ajax = new XMLHttpRequest();
	// ajax untuk mngambil data nisn berdasarkanyg diketik
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			let response = ajax.responseText;
			nisnWrapper.innerHTML = response
		}
	};
	ajax.open('get', `src/search-nisn.php?nisn=${this.value}`, true);
	ajax.send();

})






function getNisn(val){
	nisnInput.value = val
}


// set harga berdasrkan tahun spp
const tahunSpp = document.querySelector('#tahun-spp')
const harga = document.querySelector('#harga')

tahunSpp.addEventListener('change', function(){
	const ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			let response = ajax.responseText;
			harga.value = response
		}
	};
	ajax.open('get', `src/get-nominal.php?tahun=${this.value}`, true);
	ajax.send();
})