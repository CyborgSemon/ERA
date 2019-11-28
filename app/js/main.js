function $ (ele) {
	return document.querySelector(ele);
}

function snackbar (msg) {
	$('#snackbarMsg').innerText = msg;
	$('#snackbar').style.bottom = '20px';
	setTimeout(()=> {
		$('#snackbar').style.bottom = '-48px';
	}, 4000);
}