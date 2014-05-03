/* datatables helpers */
function styledt(table){
	$(table+'-container .dataTables_filter label').addClass('pull-right'); 
	$(table+'-container .dataTables_filter input').attr('placeholder', 'Search'); 
	$(table+'-container .dataTables_filter input').addClass('form-control');
	$(table+'-container .dataTables_length select').addClass('form-control');
	$(table+'-container .dt-pop-control').detach().prependTo('.dataTables_filter')
	$(table+'-container .dataTables_paginate').addClass('pull-right');
}

function dtLoad(table, action, hidemd, hidesm, hide, hascontrols){
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
		aaSorting: [[0, 'desc']],
		"oLanguage": {
				"sLengthMenu": "Limit _MENU_",
				"sSearch": "",
					"oPaginate": {
					"sPrevious": "",
				"sNext": ""
			  }
		  },
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			if ( $.inArray(aData[0], aSelected) !== -1 )  $(nRow).find('td').not(':last-child').toggleClass('highlight');
		 },
		"fnDrawCallback": function ( oSettings ) {
			
			oTable.fnSetColumnVis( 0, false,false );

			$(table+' tr').find(hidemd).addClass('hidden-sm hidden-xs'); 
			$(table+' tr').find(hidesm).addClass('hidden-xs'); 
			$(table+' tr').find(hide).addClass('hidden'); 

			$('.datatable-loading').fadeOut();
			$(table+'-container').fadeIn();
		}
	});

	if(hascontrols != 'false'){
		$(document).on("click", table+' tbody tr td:last-child', function(e) {
			return false;
		});

		$(document).on("click", table+' tbody tr ', function(e) {
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

			$(this).find('td').not(':last-child').toggleClass('highlight');
		});
	}

	$(document).on("click",  table+"-container .dt-mass", function(e) {
		e.preventDefault();  

		var action=$(this).attr('data-action');
		var table=$(this).attr('data-table');
		var method=$(this).attr('data-method');
		var run=false;
		var _ids='';
		$.each(aSelected, function(i,value){ _ids+=value+','; });

		if(method == 'modal'){
			modalfyRun(this,$(this).attr('data-action')+'?ids='+_ids);
		}else if($(this).attr('data-confirm') == 'true'){
			if(action == 'user/mass/merge'){
				$.ajax({
					type: 'GET',
					url: 'user/mass/merge?ids='+_ids
				}).done(function(msg) {
					if(msg){
						bootbox.confirm(msg, function(result) {
							if(result) fnRunMass(action, table, method, aSelected);
						});
					} else {
						console.log(msg);
						bootbox.alert(lang_unable_to_exec);
					}
				}).fail(function(jqXHR, textStatus) {
						console.log(jqXHR);
						bootbox.alert( lang_unable_to_exec + textStatus);
				 });
				} else {
					bootbox.confirm(lang_areyousure, function(result) {
						if(result) fnRunMass(action, table, method, aSelected);
					});
				}
		} else fnRunMass(action, table, method, aSelected);
		return false;
	});
}

function fnRunMass(action, data_table, data_method,aSelected){
	if(!data_method) data_method='POST';
	//console.log(data_table);
	$.ajax({
			type: data_method,
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
				bootbox.alert( lang_unable_to_exec + msg.error);
			}
	  }).fail(function(jqXHR, textStatus) {
			console.log(jqXHR);
			bootbox.alert( lang_unable_to_exec + textStatus);
	  });
}
