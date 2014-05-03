
/* security for ajax */
$.ajaxSetup({data:{csrf_token:$('meta[name="csrf-token"]').attr("content")}});



$(document).on('click', '.ajax-alert-confirm', function(e) {
	e.preventDefault();    
	var data_table = $(this).attr('data-table'); 
	var data_row = $(this).attr('data-row'); 
	var link = $(this).attr('href'); 
	var data_method=$(this).attr('data-method');
	var data_type=$(this).attr('data-type');
	if(!data_type) data_type='json';
	if(!data_method) data_method='POST';

	bootbox.confirm(lang_areyousure, function(result) {    
		if (result) {
			$.ajax({
				type: data_method,
				dataType: data_type,
				url: link
			}).done(function(msg) {
				if(data_type == 'json'){
					if(msg.result == 'success'){
						if(data_row){
							$('#site-modal').modal('hide')
							oTable = $('#'+data_table).dataTable();
							oTable.fnReloadAjax();
						//	var index = jQuery.inArray(data_row, aSelected);
						//	aSelected.splice( index, 1 );
						} else {
							$('#site-modal').modal('hide');
						}
					}else {
						console.log(msg);
						bootbox.alert( lang_unable_to_exec + msg.error);
					}
				}
			}).fail(function( jqXHR, textStatus ) {
 					console.log(jqXHR);
					bootbox.alert( lang_unable_to_exec + textStatus);
			});
		}    
	});
	return false;
});

$(document).on('submit', '.form-ajax', function(e) {
	$('input[type=button], input[type=submit]').attr('disabled', true).addClass('disabled');
	$.post(
		$(this).attr('action'),
		$(this).serialize(),
		function(data){
			$('#site-modal').html(data);
			$('html, body, #site-modal').animate({ scrollTop: 0 }, 0);
			$('input[type=button], input[type=submit]').attr('disabled', false).removeClass('disabled');
			//console.log(data);
		}
	);
	return false;   
}); 


function modalfyRun(th,url){
	$.ajax({
		type: 'GET',
		url: url
	}).done(function(msg) {
		if(msg){
			$('#site-modal').html(msg).modal();
		} else {
			console.log(msg);
			bootbox.alert(lang_unable_to_exec);
		}
	}).fail(function(jqXHR, textStatus) {
			console.log(jqXHR);
			bootbox.alert( lang_unable_to_exec + textStatus);
	 });
}

/* helpers */


function loadWeather(location, woeid) {
	if(localStorage.getItem('weather_time') > 0 && ((new Date().getTime() - localStorage.getItem('weather_time'))/1000 < 300)){
		$('.panel-weather').html(localStorage.getItem('weather_html'));
	} else {
	  $.simpleWeather({
		location: location,
		woeid: woeid,
		unit: 'f',
		success: function(weather) {
			$('.panel-weather').hide();
			$('.panel-weather').html('<a href="#"><span class=" icon-'+weather.code+'"></span> '+weather.temp+'&deg; '+ weather.currently+'</a>');
			$('.panel-weather').attr('title', weather.city + ', '+ weather.region );
			$('.panel-weather').show();
			localStorage.setItem('weather_html',$(".panel-weather").html());
			localStorage.setItem('weather_time',new Date().getTime());
		}
	  });
	}
}

function _resize_sparkline(data){
	if( $( window ).width() > 760){
		var _w=(($( window ).width()/4)/6)-9;
	} else 	var _w=(($( window ).width()/2)/6)-11;

	$.each(data, function(i,value){ 
		$('#spark_'+ i).sparkline(value.data.reverse(), { enableTagOptions: true , barWidth: _w, barSpacing: '6' });
	});
}


$(document).on('click','.btn-toggle',function(a){a.preventDefault();$(this).find('.btn').toggleClass('active');if($(this).find('.btn-primary').size()>0){$(this).find('.btn').toggleClass('btn-primary')}if($(this).find('.btn-danger').size()>0){$(this).find('.btn').toggleClass('btn-danger')}if($(this).find('.btn-success').size()>0){$(this).find('.btn').toggleClass('btn-success')}if($(this).find('.btn-info').size()>0){$(this).find('.btn').toggleClass('btn-info')}});
$(document).on('click','.ajax-alert',function(a){a.preventDefault();bootbox.confirm(lang_areyousure,function(b){if(b){document.location.href=$(this).attr('href')}})});
$(document).on('click','a',function(a){if($(this).attr('href')=='#'){return false}});
$(document).on('click','.modalfy',function(a){a.preventDefault();modalfyRun(this,$(this).attr('href'))});
$(document).on('click','.link-through',function(a){window.location=$(this).attr('href')});


function throttle(b,a){var c=null;return function(){var e=this,d=arguments;clearTimeout(c);c=window.setTimeout(function(){b.apply(e,d)},a||500)}};
function nextTab(a){$(a+' li.active').next().find('a[data-toggle="tab"]').click()}
function prevTab(a){$(a+' li.active').prev().find('a[data-toggle="tab"]').click()};