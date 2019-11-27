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

$('#newUser').addEventListener('click', ()=> {
	$('body').classList.add('addStudent');
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

$('#acceptNew').addEventListener('click', ()=> {
	let username = $('#usernameNew').value;
	let firstName = $('#firstNameNew').value;
	let lastName = $('#lastNameNew').value;
	let email = $('#emailNew').value;
	let profile = $('#profileNew');

	let r1 = $('#r1');
	let r2 = $('#r2');
	let r3 = $('#r3');

	if (username == null || username == '',	firstName == null || firstName == '', lastName == null || lastName == '', email == null || email == '', profile.value == '') {
		snackbar('Please fill in all the fields');
	} else if (!r1.checked && !r2.checked && !r3.checked) {
		snackbar('Please add a class');
	} else {
		let className = '';
		if (r1.checked) {
			className = r1.value;
		}
		if (r2.checked) {
			className = r2.value;
		}
		if (r3.checked) {
			className = r3.value;
		}
		AjaxRequest('includes/upload.php', {image: profile.files[0], urlOnly: 'yes'}).then((x)=> {
			if (x == 'failed') {
				snackbar('Image failed to upload.');
			} else {
				AjaxRequest('includes/addUser.php', {username: username, firstName: firstName, lastName: lastName, email: email, class: className, profile: x}).then((xx)=> {
					if (xx == 'done') {
						snackbar('Student added');
						$('body').classList.remove('addStudent');
						$('#usernameNew').value = '';
						$('#firstNameNew').value = '';
						$('#lastNameNew').value = '';
						$('#emailNew').value = '';
						profile.value = '';
						r1.checked = false;
						r2.checked = false;
						r3.checked = false;
					} else {
						snackbar(xx);
					}
				});
			}
		});
	}
});

$('#cancel').addEventListener('click', ()=> {
	type = '';
	$('body').classList.remove('inactive');
	$('#dialog').dataset.student = '-1';
});

$('#cancelNew').addEventListener('click', ()=> {
	$('body').classList.remove('addStudent');
});