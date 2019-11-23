let header = document.getElementById('header');
let main = document.getElementById('main');
let sideNav = document.getElementById('sideNav');
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

document.getElementById('mobile').addEventListener('click', ()=> {
		main.style.marginLeft = "25vw";
		sideNav.classList.add('active');
});

document.getElementById('sideClose').addEventListener('click', ()=>{
	 main.style.marginLeft = "0";
	 sideNav.classList.remove('active');
});
