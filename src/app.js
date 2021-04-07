const forms = document.querySelectorAll('form')
const nisn = document.querySelector('input[name=nisn]')
const container = document.querySelector('#payment-history')

// form login
const username = document.querySelector('#username')
const password = document.querySelector('#password')
const btnLogin = document.querySelector('button[name=login]')
const error = document.querySelector('#error-message')
const err = document.querySelector('.err')

forms.forEach( form => {
	form.addEventListener('submit', (e) => {
		e.preventDefault()
		if (e.target.id == 'form-login') {
			btnLogin.innerText = 'Loading...'
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4 && ajax.status == 200) {
					let response = ajax.responseText;
					if (response != '') {
						btnLogin.innerText = 'Login'

						if (response == 'sukses') {
							btnLogin.innerText = 'Redirecting...'
							window.location.href = 'admin/dashboard'
						}else{
							error.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
											  ${response}
											  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>`
						}

						
					}
				}
			};
			ajax.open('POST', `admin/src/login.php`, true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(`username=${username.value}&&password=${password.value}`);
		}
		// Jika yg disubmit form pembayaran
		if (e.target.id == 'cek-pembayaran') {
			container.innerHTML = 'Loading...'
			const ajax = new XMLHttpRequest();
			ajax.onreadystatechange = function() {
				if (ajax.readyState == 4 && ajax.status == 200) {
					let response = ajax.responseText;
					container.innerHTML = response

				}
			};
			ajax.open('get', `admin/src/payment-check.php?nisn=${nisn.value}`, true);
			ajax.send();
		}
	})
});

const hidePassword = document.querySelector('#password-hider')
const inputPassword = document.querySelector('input[type=password]')

hidePassword.addEventListener('click', function() {
	if (this.getAttribute('data-password') == 'hide') {
		inputPassword.setAttribute('type', 'text')
		hidePassword.setAttribute('data-password', 'show')
		hidePassword.innerHTML = `<i class="fa fa-eye-slash"></i>`
	}else{
		inputPassword.setAttribute('type', 'password')
		hidePassword.setAttribute('data-password', 'hide')
		hidePassword.innerHTML = `<i class="fa fa-eye"></i>`
	}

})