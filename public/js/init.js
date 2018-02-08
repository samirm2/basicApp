$(function(){
	$('#modal').modal();
	$('.chips-autocomplete').material_chip({
		autocompleteOptions: {
    	  data: {
	        'Apple': null,
	        'Microsoft': null,
	        'Google': null
      	},
      	limit: Infinity,
      	minLength: 3
    	}
	});
	$('select').material_select();
	$('.datepicker').pickadate();
	$('.dropify').dropify({
		messages: {
        'default': 'Has Clic o Arrastra y Suelta Un Archivo Aqui',
        'replace': 'Has Clic o Arrastra y Suelta Un Archivo Aqui Para Reemplazar',
        'remove':  'Eliminar',
        'error':   'Ooops, Ha ocurrido un Error.'
    }
	});
});