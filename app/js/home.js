function $(element) {
	return document.querySelector(element);
}

let editor = undefined;

if (typeof data !== 'undefined') {
	editor = new EditorJS({
		holder: 'editor',
		placeholder: 'Click here to start writing',
		tools: {
			header: Header,
			image: {
				class: ImageTool,
				inlineToolbar: true,
				config: {
					endpoints: {
						byFile: 'includes/upload.php'
					}
				}
			},
			embed: {
				class: Embed,
				inlineToolbar: true,
				config: {
					services: {
						youtube: true,
						vimeo: true
					}
				}
			}
		},
		data: data,
		onReady: ()=> {
			[].forEach.call(document.querySelectorAll('[contenteditable=true]'), (e)=> {
				e.dataset.gramm_editor = 'false';
			});
		}
	});
} else {
	editor = new EditorJS({
		holder: 'editor',
		placeholder: 'Click here to start writing',
		tools: {
			header: Header,
			image: {
				class: ImageTool,
				inlineToolbar: true,
				config: {
					endpoints: {
						byFile: 'includes/upload.php'
					}
				}
			},
			embed: {
				class: Embed,
				inlineToolbar: true,
				config: {
					services: {
						youtube: true,
						vimeo: true
					}
				}
			}
		}
	});
}

function snackbar (msg) {
	$('#snackbarMsg').innerText = msg;
	$('#snackbar').style.bottom = '20px';
	setTimeout(()=> {
		$('#snackbar').style.bottom = '-48px';
	}, 4000);
}

$('#save').addEventListener('click', ()=> {
	editor.save().then((result)=> {
		AjaxRequest('includes/save.php', {'data':JSON.stringify(result)}).then((x)=> {
			if (x == 'done') {
				snackbar('Portfolio submitted for review');
			} else if (x == 'updated') {
				snackbar('Portfolio updated');
			} else {
				snackbar(x);
				return;
			}
			$('#draftStatus').innerText = 'Draft portfolio status: pending';
		});
	}).catch((err) =>{
		console.log('Something went wrong', err);
	})
});

$('#uplaodImage').addEventListener('click', ()=> {
	$('body').classList.add('addProfileImage');
});

$('#cancelImage').addEventListener('click', ()=> {
	$('body').classList.remove('addProfileImage');
	$('#newProfile').value = '';
});

$('#acceptImage').addEventListener('click', ()=> {
	if ($('#newProfile').value != '') {
		let _URL = window.URL || window.webkitURL;
		let img = new Image();
		img.onload = function () {
			if (this.width == this.height) {
				AjaxRequest('includes/upload.php', {image: $('#newProfile').files[0], urlOnly: 'yes', profileImageSet: 'yes'}).then((x)=> {
					if (x == 'failed') {
						snackbar('There was an issue with uploading');
					} else {
						$('#profileImage').src = x;
						$('body').classList.remove('addProfileImage');
						$('#newProfile').value = '';
					}
				});
			} else {
				snackbar('The image must be exactly square');
			}
        };
        img.src = _URL.createObjectURL($('#newProfile').files[0]);
	} else {
		snackbar('You must upload an image');
	}
});
