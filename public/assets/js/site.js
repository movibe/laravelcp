/* modalfy @ https://github.com/gcphost/modalfy */
function modalfy(){
	$( '.modalfy').click(function() {
		bootbox.dialog({
			message:'<iframe border="0" height="100%" width="100%" src="'+$(this).attr("href")+'">',
			onEscape: function() {},
			animate: true,
			className: "full-modal",
		});
		return false;
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


function styledt(){
	$('.dataTables_filter input').attr('placeholder', 'Search'); 
	$('.dataTables_filter input').addClass('form-control');
	$('.dataTables_length select').addClass('form-control');
	$(".dt-pop-control").detach().appendTo('.dataTables_filter')
}

function dtLoad(table, action, hidemd, hidesm){
	 var oTable=$(table).dataTable( {
		"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
		"sPaginationType": "bootstrap",
		"bAutoWidth": false,
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": action,"bRetrieve": true,
		"fnInitComplete": function ( oSettings ) {
			styledt();
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
			if ( jQuery.inArray(aData.DT_RowId, aSelected) !== -1 ) {
				$(nRow).addClass('highlight');
			}
		 },
		"fnDrawCallback": function ( oSettings ) {
			modalfy();
			
			$(table+' tr').find(hidemd).addClass('hidden-sm, hidden-xs'); 
			$(table+' tr').find(hidesm).addClass('hidden-xs'); 

			
			$('.datatable-loading').fadeOut();
			$(' .dt-wrapper').fadeIn();

			$(table+' tbody tr').click( function () {
				var aData = oTable.fnGetData( this );
				var id = $(this).find('.btn-group').attr('data-id');
				var index = jQuery.inArray(id, aSelected);

				if ( index === -1 ) {
					aSelected.push( id );
				} else aSelected.splice( index, 1 );
				
				 if(aSelected.length > 0){
					 $('.dt-pop-control').fadeIn();
				 } else $('.dt-pop-control').fadeOut();

				$(this).toggleClass('highlight');
			} );


		}
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
				url: link
			}).done(function() {
				bootbox.hideAll();
				oTable = $('#'+data_table).dataTable();
				oTable.fnReloadAjax();
				var index = jQuery.inArray(data_row, aSelected);
				aSelected.splice( index, 1 );

			});
		}    
	});
	return false;
});

$(document).on("click", ".dt-mass", function(e) {
	e.preventDefault();    
	var action=$(this).attr('data-action');
	var run=false;
	if($(this).attr('data-method') == 'delete'){
		bootbox.confirm('Are you sure?', function(result) {
			if(result) run=true;
		});
	} else run=true;

	if(run){
		$.ajax({
		  type: "POST",
		  url: action,
		  data: { rows: JSON.stringify(aSelected) }
		})
		  .done(function( msg ) {
			oTable.fnReloadAjax();
			$(".dt-pop-control").fadeOut();
			aSelected=[];
		  }).fail(function(msg) {
			bootbox.alert( "Unable to delete rows. " +msg );
		  });
	}
});

 $(function() {      
      $(".main-nav").swipe( {
        swipe:function(event, direction, distance, duration, fingerCount) {
			if(direction == "down") $('.main-nav .collapse').collapse('show');
			if(direction == "up") $('.main-nav .collapse').collapse('hide');
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




    });
