let type = '';

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

[].forEach.call(document.querySelectorAll('.memberCard'), (e)=> {
	if (e.dataset.id) {
		let id = e.dataset.id;
		let name = e.dataset.name;

		let accept = $(`#accept${id}`);
		let fail = $(`#fail${id}`);
		let feedback = $(`#feedback${id}`);

		accept.addEventListener('click', ()=> {
			if (feedback.value) {
				type = 'pass';
				$('body').classList.add('inactive');
				$('#txt').innerHTML = `Are you sure you would like to <b>APPROVE</b> ${name}'s portfolio?`;
				$('#dialog').dataset.student = id;
			} else {
				feedback.focus();
				snackbar('You must provide feedback');
			}
		});
		fail.addEventListener('click', ()=> {
			if (feedback.value) {
				type = 'fail';
				$('body').classList.add('inactive');
				$('#txt').innerHTML = `Are you sure you would like to <b>DECLINE</b> ${name}'s portfolio?`;
				$('#dialog').dataset.student = id;
			} else {
				feedback.focus();
				snackbar('You must provide feedback');
			}
		});
	}
});

$('#accept').addEventListener('click', ()=> {
	let studentId = $('#dialog').dataset.student;
	console.log(studentId);
	AjaxRequest('includes/review.php', {active:type, feedback:$(`#feedback${studentId}`).value, userId:studentId}).then((x)=> {
		if (x == 'Review sent' || x == 'Portfolio passed') {
			type = '';
			$('#dialog').dataset.student = '-1';
			$('body').classList.remove('inactive');

			let card = $(`[data-id="${studentId}"]`);
			card.parentNode.removeChild(card);

			snackbar(x);
		} else {
			snackbar(x);
		}
	});
});

$('#cancel').addEventListener('click', ()=> {
	type = '';
	$('body').classList.remove('inactive');
	$('#dialog').dataset.student = '-1';
});