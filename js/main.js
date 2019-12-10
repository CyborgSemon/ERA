function $ (eve) {
	if (eve.startsWith('#') || eve == 'body') {
		return document.querySelector(eve);
	} else {
		return document.querySelectorAll(eve);
	}
}

let header = $('#header');
let footer = $('#footer');

$('#exit').addEventListener('click', ()=> {
	header.classList.remove('active');
	footer.classList.remove('active');
	$('body').classList.remove('active');
	$('#students').style.overflowY = 'auto';
});

[].forEach.call($('.card'), (e)=> {
	let studentNum = e.dataset.id;
	e.addEventListener('click', ()=> {
		let studentName = data[studentNum]['firstName'] + ' ' + data[studentNum]['lastName'];
		let studentClass = data[studentNum]['class'];
		let studentClassString = '';
		if (studentClass == 'web') {
			studentClassString = 'Web & UX Design';
		} else if (studentClass == 'game') {
			studentClassString = 'Game Art & Development';
		} else if (studentClass == 'graphic') {
			studentClassString = 'Creative Digital Design';
		}
		let profile;
		if (data[studentNum]['profileImage'] == null) {
			profile = 'images/default-profile.png';
		} else {
			profile = data[studentNum]['profileImage'];
		}

		$('#profile').innerHTML = `<img src="${profile}" alt="Image of ${studentName}"><h2>${studentName}</h2><p class="${studentClass}">${studentClassString}</p>`;

		$('#content').innerHTML = renderContent(data[studentNum]['dataJSON']);

		$('#students').style.overflowY = 'hidden';

		header.classList.add('active');
		footer.classList.add('active');
		$('body').classList.add('active');
	});
});

function renderContent (jsonString) {
	let data = JSON.parse(jsonString);

	let content = '';

	let templateStart = '<div class="block">';
	let templateEnd = '</div>';

	for (let i = 0; i < data.blocks.length; i++) {
		let item = data.blocks[i];
		switch (item.type) {
			case 'header':
				content += `${templateStart}<h${item.data.level}>${item.data.text}</h${item.data.level}>${templateEnd}`;
				break;
			case 'paragraph':
				content += `${templateStart}<p>${item.data.text}</p>${templateEnd}`;
				break;
			case 'image':
				if (item.data.stretched) {
					content += '<div class="block full">';
				} else {
					content += templateStart;
				}
				content += `<img src="${item.data.file.url}" alt="${item.data.caption}">`;

				if (data.blocks[i].data.caption) {
					content += `<div class="caption">- ${item.data.caption}</div>`;
				}
				content += templateEnd;
				break;
			case 'embed':
				content += `${templateStart}<iframe height="320" src="${item.data.embed}" frameborder="0" allowfullscreen></iframe>`;
				if (data.blocks[i].data.caption) {
					content += `<div class="caption">- ${item.data.caption}</div>`;
				}
				content += templateEnd;
				break;
		}
	}

	return content;
}

let allToggle = true;
let webToggle = true;
let graphicToggle = true;
let gameToggle = true;

$('#allBtn').addEventListener('click', ()=> {
	if (!allToggle) {
		if (!$('#allBtn').classList.contains('active')) {
			$('#allBtn').classList.add('active');
		}
		if (!$('#webBtn').classList.contains('active')) {
			$('#webBtn').classList.add('active');
		}
		if (!$('#graphicBtn').classList.contains('active')) {
			$('#graphicBtn').classList.add('active');
		}
		if (!$('#gameBtn').classList.contains('active')) {
			$('#gameBtn').classList.add('active');
		}

		[].forEach.call($('.card'), (e)=> {
			if (e.style.display == 'none') {
				e.style.display = 'flex';
			}
		});
		allToggle = true;
		webToggle = true;
		graphicToggle = true;
		gameToggle = true;
		checkStudents();
	}
});

$('#webBtn').addEventListener('click', ()=> {
	if ($('#allBtn').classList.contains('active')) {
		$('#allBtn').classList.remove('active');
	}
	if (!$('#webBtn').classList.contains('active')) {
		$('#webBtn').classList.add('active');
	}
	if ($('#graphicBtn').classList.contains('active')) {
		$('#graphicBtn').classList.remove('active');
	}
	if ($('#gameBtn').classList.contains('active')) {
		$('#gameBtn').classList.remove('active');
	}
	[].forEach.call($('.card'), (e)=> {
		if (e.classList.contains('web')) {
			e.style.display = 'flex';
		} else {
			e.style.display = 'none';
		}
	});
	allToggle = false;
	webToggle = true;
	graphicToggle = false;
	gameToggle = false;
	checkStudents();
});

$('#graphicBtn').addEventListener('click', ()=> {
	if ($('#allBtn').classList.contains('active')) {
		$('#allBtn').classList.remove('active');
	}
	if ($('#webBtn').classList.contains('active')) {
		$('#webBtn').classList.remove('active');
	}
	if (!$('#graphicBtn').classList.contains('active')) {
		$('#graphicBtn').classList.add('active');
	}
	if ($('#gameBtn').classList.contains('active')) {
		$('#gameBtn').classList.remove('active');
	}
	[].forEach.call($('.card'), (e)=> {
		if (e.classList.contains('graphic')) {
			e.style.display = 'flex';
		} else {
			e.style.display = 'none';
		}
	});
	allToggle = false;
	webToggle = false;
	graphicToggle = true;
	gameToggle = false;
	checkStudents();
});

$('#gameBtn').addEventListener('click', ()=> {
	if ($('#allBtn').classList.contains('active')) {
		$('#allBtn').classList.remove('active');
	}
	if ($('#webBtn').classList.contains('active')) {
		$('#webBtn').classList.remove('active');
	}
	if ($('#graphicBtn').classList.contains('active')) {
		$('#graphicBtn').classList.remove('active');
	}
	if (!$('#gameBtn').classList.contains('active')) {
		$('#gameBtn').classList.add('active');
	}
	[].forEach.call($('.card'), (e)=> {
		if (e.classList.contains('game')) {
			e.style.display = 'flex';
		} else {
			e.style.display = 'none';
		}
	});
	allToggle = false;
	webToggle = false;
	graphicToggle = false;
	gameToggle = true;
	checkStudents();
});

function checkStudents () {
	if (!gameToggle && !graphicToggle && !webToggle) {
		$('#studentError').innerText = 'No students';
	} else {
		let pendingCheck = false;
		[].forEach.call($('.card'), (e)=> {
			if (e.style.display != 'none') {
				pendingCheck = true;
			}
		});
		if (pendingCheck) {
			$('#studentError').innerText = '';
		} else {
			$('#studentError').innerText = 'No students';
		}
	}
}
