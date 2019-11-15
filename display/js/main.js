let header = document.getElementById('header');
let footer = document.getElementById('footer');

document.getElementById('graphic').addEventListener('click', ()=> {
  console.log('clonk');
	if (header.classList.contains('active')) {
		header.classList.remove('active');
		footer.classList.remove('active');
	} else {
		header.classList.add('active');
		footer.classList.add('active');
	}
});
