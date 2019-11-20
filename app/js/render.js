console.log(data);

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

document.getElementById('content').innerHTML = content;