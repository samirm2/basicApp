$(function(){
	$('#modal').modal();
	$('select').material_select();
	$('.datepicker').pickadate();
	$('.dropify').dropify({
		messages: {
        'default': 'Has Clic o Arrastra y Suelta Un Archivo Aqui',
        'replace': 'Has Clic o Arrastra y Suelta Un Archivo Aqui Para Reemplazar',
        'remove':  'Eliminar',
        'error':   'Ooops, Ha ocurrido un Error.'
    	},
    	error: {
        'fileSize': 'The file size is too big ({{ value }} max).',
        'minWidth': 'The image width is too small ({{ value }}}px min).',
        'maxWidth': 'The image width is too big ({{ value }}}px max).',
        'minHeight': 'The image height is too small ({{ value }}}px min).',
        'maxHeight': 'The image height is too big ({{ value }}px max).',
        'imageFormat': 'El formato de archivo no esta permitido(solo {{ value }}).'
    	}
	});
});