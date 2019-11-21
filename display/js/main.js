let header = document.getElementById('header');
let footer = document.getElementById('footer');

document.getElementById('graphic').addEventListener('click', ()=> {
	console.log('haha')
	if (header.classList.contains('active')) {
		header.classList.remove('active');
		footer.classList.remove('active');
	} else {
		header.classList.add('active');
		footer.classList.add('active');
	}
});

document.getElementById('exit').addEventListener('click', ()=> {
  header.classList.remove('active');
  footer.classList.remove('active');
});
