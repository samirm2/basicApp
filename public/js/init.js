$(function(){
    $('.modal').modal();
	$('select').material_select();
	$('.datepicker').pickadate({
        format: 'yyyy/mm/dd',
        max: true,
        today: 'Hoy',
        clear: 'Limpiar',
        selectYears: true,
        selectMonths: true,
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
    });
	$('.dropify').dropify({
		messages: {
        'default': 'Has Clic o Arrastra y Suelta Un Archivo Aqui',
        'replace': 'Has Clic o Arrastra y Suelta Un Archivo Aqui Para Reemplazar',
        'remove':  'Eliminar',
        'error':   'Ha ocurrido un Error.'
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