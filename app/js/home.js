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
						byFile: 'http://localhost/projects/ERA/app/includes/upload.php'
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
			},
			list: {
				class: List,
				inlineToolbar: true,
			}
		},
		data: data
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
						byFile: 'http://localhost/projects/ERA/app/includes/upload.php'
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
			},
			list: {
				class: List,
				inlineToolbar: true,
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
			} else if ('updated') {
				snackbar('Portfolio updated');
			} else {
				snackbar('There was an error. Try again');
			}
		});
	}).catch((err) =>{
		console.log('Something went wrong', err);
	})
});