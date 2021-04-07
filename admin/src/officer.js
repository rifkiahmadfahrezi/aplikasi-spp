const officerName = document.querySelector('#nama')
const officerUsername = document.querySelector('#username')
const officerPassword = document.querySelector('#password')

officerName.addEventListener('input', () => {
	officerUsername.value = officerName.value.split(' ')[0].toLowerCase()
	officerPassword.value = officerUsername.value
})