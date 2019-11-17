const editor = new EditorJS({
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

document.getElementById('save').addEventListener('click', ()=> {
	editor.save().then((result)=> {
		console.log(result);
	}).catch((err) =>{
		console.log('Something went wrong', err);
	})
});