/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-home' : '&#xe000;',
			'icon-pencil' : '&#xe006;',
			'icon-user' : '&#xe037;',
			'icon-key' : '&#xe03f;',
			'icon-equalizer' : '&#xe04e;',
			'icon-remove' : '&#xe05e;',
			'icon-enter' : '&#xe098;',
			'icon-exit' : '&#xe099;',
			'icon-mail' : '&#xe015;',
			'icon-calendar' : '&#xe01b;',
			'icon-clipboard' : '&#xe072;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};