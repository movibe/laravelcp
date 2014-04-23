


/* modalfy @ https://github.com/gcphost/modalfy */
$(document).on("click", ".modalfy", function(e) {
	e.preventDefault();   
	if($(this).attr("data-iframe") == true){
		modalfyRunIframe($(this).attr("href"));
	} else modalfyRun($(this).attr("href"));
	return false;
});


function modalfyRunIframe(src){
	bootbox.dialog({
		message:'<iframe border="0" height="100%" width="100%" src="'+src+'">',
		onEscape: function() {},
		animate: true,
		className: "full-modal modal-lg",
	});
}

function modalfyRun(src){
	$.ajax({
		type: 'GET',
		url: src
	}).done(function(msg) {
		if(msg){
			$('#site-modal').html(msg).modal();
			

		}else {
			console.log(msg);
			bootbox.alert( "Unable to execute command.");
		}
	});
}

function modalfyIframes(){
	$('.modal-dialog iframe').each(function(){
		$(this).css('height',($(this).parents().find('.modal-body').height() + 75) + 'px' );
	});
}

$(window).on('resize load',modalfyIframes);

/* security for ajax */
$.ajaxSetup({
	data: {
		'csrf_token': $('meta[name="csrf-token"]').attr('content')
	}
});

/* datatables helpers */


function styledt(table){
	$(table+'-container .dataTables_filter label').addClass('pull-right'); 
	$(table+'-container .dataTables_filter input').attr('placeholder', 'Search'); 
	$(table+'-container .dataTables_filter input').addClass('form-control');
	$(table+'-container .dataTables_length select').addClass('form-control');
	$(table+'-container .dt-pop-control').detach().prependTo('.dataTables_filter')
	$(table+'-container .dataTables_paginate').addClass('pull-right');
}

function dtLoad(table, action, hidemd, hidesm){
	var aSelected = [];
	var oTable=$(table).dataTable( {
		"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
		"sPaginationType": "bootstrap",
		"bAutoWidth": false,
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": action,"bRetrieve": true,
		"fnInitComplete": function ( oSettings ) {
			styledt(table);
		},
		"oLanguage": {
				"sLengthMenu": "Limit _MENU_",
				"sSearch": "",
					"oPaginate": {
					"sPrevious": "",
				"sNext": ""
			  }
		  },
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( $.inArray(aData[0], aSelected) !== -1 )  $(nRow).addClass('highlight');
		 },
		"fnDrawCallback": function ( oSettings ) {
			
			oTable.fnSetColumnVis( 0, false,false );

			$(table+' tr').find(hidemd).addClass('hidden-sm hidden-xs'); 
			$(table+' tr').find(hidesm).addClass('hidden-xs'); 

			$('.datatable-loading').fadeOut();
			$(table+'-container').fadeIn();
		}
	});

	$(document).on("click", table+' tbody tr', function(e) {
		e.preventDefault();    
		var aData = oTable.fnGetData( this );
		var id = aData[0];
		var index = $.inArray(id, aSelected);
		if ( index === -1 ) {
			aSelected.push( id );
		} else aSelected.splice( index, 1 );
		
		 if(aSelected.length > 0){
			 $(table+'-container .dt-pop-control').fadeIn();
		 } else $(table+'-container .dt-pop-control').fadeOut();

		$(this).toggleClass('highlight');
	} );

	$(document).on("click", ".dt-mass", function(e) {
		e.preventDefault();    
		var action=$(this).attr('data-action');
		var table=$(this).attr('data-table');
		var run=false;
		if($(this).attr('data-method') == 'modal'){
			var _ids='';
			$.each(aSelected, function(i,value){ _ids+=value+','; });
			modalfyRun($(this).attr('data-action')+'?ids='+_ids);
		}else if($(this).attr('data-confirm') == 'true'){
			bootbox.confirm('Are you sure?', function(result) {
				if(result) fnRunMass(action, table);
			});
		} else fnRunMass(action, table);
	});
}

$(document).on("click", ".ajax-alert", function(e) {
	e.preventDefault();    
	bootbox.confirm("Are you sure?", function(result) {    
		if (result) document.location.href = $(this).attr("href");    
	});
});

$(document).on("click", ".ajax-alert-confirm", function(e) {
	e.preventDefault();    
	var data_table = $(this).attr("data-table"); 
	var data_row = $(this).attr("data-row"); 
	var link = $(this).attr("href"); 
	bootbox.confirm("Are you sure?", function(result) {    
		if (result) {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: link
			}).done(function(msg) {
				if(msg.result == "success"){
					bootbox.hideAll();
					oTable = $('#'+data_table).dataTable();
					oTable.fnReloadAjax();
					var index = jQuery.inArray(data_row, aSelected);
					aSelected.splice( index, 1 );
				}else {
					console.log(msg);
					bootbox.alert( "Unable to execute command, "+ msg.error);
				}
			});
		}    
	});
	return false;
});

$(document).on("submit", ".form-ajax", function(e) {
  $.post(
   $(this).attr('action'),
	$(this).serialize(),
	function(data){
	  $("#site-modal").html(data)
	}
  );
  return false;   
}); 

$(document).on("click", "a", function(e) {
	if($(this).attr('href')=='#') return false;
});


function fnRunMass(action,data_table){
	console.log(data_table);
		$.ajax({
		  type: "POST",
		  url: action,
			dataType: 'json',
		  data: { rows: JSON.stringify(aSelected) }
		})
	  .done(function( msg ) {
			if(msg.result == "success"){
				aSelected=[];
				oTable = $('#'+data_table).dataTable();
				oTable.fnReloadAjax();
				$(".dt-pop-control").fadeOut();
			}else {
				console.log(msg);
				bootbox.alert( "Unable to execute command, "+ msg.error);
			}
	  }).fail(function(msg) {
		console.log(msg);
		bootbox.alert( "Unable to execute command");
	  });
}


function loadWeather(location, woeid) {
  $.simpleWeather({
    location: location,
    woeid: woeid,
    unit: 'f',
    success: function(weather) {
		 $(".panel-weather").hide();
      $(".panel-weather").html('<a href="#"><span class=" icon-'+weather.code+'"></span> '+weather.temp+'&deg; '+ weather.currently+'</a>');
	  $(".panel-weather").attr('title', weather.city + ', '+ weather.region );
	   $(".panel-weather").show();
    },
    error: function(error) {
      $(".panel-weather").html(error);
    }
  });
}

function _resize_sparkline(){
	if( $( window ).width() > 760){
		var _w=(($( window ).width()/4)/10)-9;
	} else 	var _w=(($( window ).width()/2)/10)-10;
	$('.sparklines').sparkline([4,6,1,4,7,1,5,8,9,2], { enableTagOptions: true , barWidth: _w, barSpacing: '3' });
}


$(document).ready(function() {


	$(".main-nav").swipe( {
	swipe:function(event, direction, distance, duration, fingerCount) {
		if(direction == "down") $('.main-nav .collapse').collapse('show');
		if(direction == "right") $('.sidebar').collapse('show');
		if(direction == "left") $('.sidebar').collapse('hide');
	},
	 threshold:0
	});

	$(".sidebar").swipe( {
	swipe:function(event, direction, distance, duration, fingerCount) {
		if(direction == "left") $('.sidebar').collapse('hide');
	},
	 threshold:0
	});



	if ("geolocation" in navigator) {
	  navigator.geolocation.getCurrentPosition(function(position) {
		loadWeather(position.coords.latitude+','+position.coords.longitude); //load weather using your lat/lng coordinates
	  });
	} else loadWeather('Seattle',''); 

});

