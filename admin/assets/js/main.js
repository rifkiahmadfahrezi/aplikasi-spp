// preload animation
const preloadElement = document.querySelector('.preloader')

window.addEventListener('load', () => {
	preloadElement.remove()
})


// navbar
const navToggler = document.querySelector('#navbar-toggler')
const sidebar = document.querySelector('aside')
const main = document.querySelector('main')

navToggler.addEventListener('click', () => {
	sidebar.classList.toggle('sidebar-hide')

	if (sidebar.classList.contains('sidebar-hide')) {
		main.classList.add('main-full')
	}else{
		main.classList.remove('main-full')
	}

})

// responsive

const mobileBreakpoint = window.matchMedia("(max-width: 576px)")
if (mobileBreakpoint.matches) { // If media query matches
sidebar.classList.add('sidebar-hide')
main.classList.add('main-full')
} else {
sidebar.classList.remove('sidebar-hide')
main.classList.remove('main-full')
}


// delete btn

const deleteButtons = document.querySelectorAll('#delete-btn')

deleteButtons.forEach(btn =>  {
	btn.addEventListener('click', function(e) {
		e.preventDefault()

		let href  = this.getAttribute('href')

		Swal.fire({
			title: 'Yakin?',
			text: 'Data ini akan dihapus',
			icon: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			cancelButtonColor: 'red'
		}).then(res => {
			if (res.isConfirmed) {
				document.location.href = href
			}
		})
	})
});