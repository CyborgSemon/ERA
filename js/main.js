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
		let studentClass = data[studentNum]['class']
		let profile;
		if (data[studentNum]['profileImage'] == null) {
			profile = 'images/default-profile.png';
		} else {
			profile = data[studentNum]['profileImage'];
		}

		$('#profile').innerHTML = `<img src="${profile}" alt="Image of ${studentName}"><h2>${studentName}</h2><p class="${studentClass}">${studentClass.charAt(0).toUpperCase() + studentClass.slice(1)}</p>`;

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

let webToggle = true;
let graphicToggle = true;
let gameToggle = true;

$('#webBtn').addEventListener('click', ()=> {
	if (webToggle) {
		$('#webBtn').classList.remove('active');
	} else {
		$('#webBtn').classList.add('active');
	}
	[].forEach.call($('.web'), (e)=> {
		if (webToggle) {
			e.style.display = 'none';
		} else {
			e.style.display = 'flex';
		}
	});
	webToggle = !webToggle;
	checkStudents();
});

$('#graphicBtn').addEventListener('click', ()=> {
	if (graphicToggle) {
		$('#graphicBtn').classList.remove('active');
	} else {
		$('#graphicBtn').classList.add('active');
	}
	[].forEach.call($('.graphic'), (e)=> {
		if (graphicToggle) {
			e.style.display = 'none';
		} else {
			e.style.display = 'flex';
		}
	});
	graphicToggle = !graphicToggle;
	checkStudents();
});

$('#gameBtn').addEventListener('click', ()=> {
	if (gameToggle) {
		$('#gameBtn').classList.remove('active');
	} else {
		$('#gameBtn').classList.add('active');
	}
	[].forEach.call($('.game'), (e)=> {
		if (gameToggle) {
			e.style.display = 'none';
		} else {
			e.style.display = 'flex';
		}
	});
	gameToggle = !gameToggle;
	checkStudents();
});

function checkStudents () {
	if (!gameToggle && !graphicToggle && !webToggle) {
		$('#studentError').innerText = 'No students';
	} else {
		let pendingCheck = false;
		[].forEach.call(document.querySelectorAll('.card'), (e)=> {
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
