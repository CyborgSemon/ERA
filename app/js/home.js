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
		},
		onChange: () => {
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
		},
		onChange: () => {
			[].forEach.call(document.querySelectorAll('[contenteditable=true]'), (e)=> {
				e.dataset.gramm_editor = 'false';
			});
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

let cropper;

$('#uplaodImage').addEventListener('click', ()=> {
	$('body').classList.add('addProfileImage');
});

$('#newProfile').addEventListener('change', ()=> {
	if ($('#newProfile').value) {
		$('#loading').style.display = 'block';
		$('#cropper').src = '';
		try {
			cropper.destroy();
		} catch(err) {}
		let currentImage = new FileReader();
		currentImage.onload = ()=> {
			$('#loading').style.display = 'none';
			$('#cropper').src = currentImage.result;
			$('#imageCropContainer').style.display = 'block';
			cropper = new Cropper($('#cropper'), {
				aspectRatio: 1 / 1,
			});
		}
		currentImage.readAsDataURL($('#newProfile').files[0]);
	}
});

$('#cancelImage').addEventListener('click', ()=> {
	$('body').classList.remove('addProfileImage');
	$('#newProfile').value = '';
	try {
		cropper.destroy();
	} catch(err){}
	$('#cropper').src = '';
	$('#imageCropContainer').style.display = 'none';
});

$('#acceptImage').addEventListener('click', ()=> {
	if ($('#newProfile').value != '') {
		AjaxRequest('includes/upload.php', {imageBlob: cropper.getCroppedCanvas().toDataURL(), urlOnly: 'yes', profileImageSet: 'yes'}).then((x)=> {
			if (x == 'failed') {
				snackbar('There was an issue with uploading');
			} else {
				cropper.destroy();
				$('#cropper').src = '';
				$('#imageCropContainer').style.display = 'none';
				$('#profileImage').src = x;
				$('body').classList.remove('addProfileImage');
				$('#newProfile').value = '';
				snackbar('Profile picture updated')
			}
		});
	} else {
		snackbar('You must have an image uploaded');
	}
});
