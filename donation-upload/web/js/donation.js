$(function(){

	var selectedId = [];
	$(this).on("click", '.select-radio .btn', function(e){
		e.preventDefault();
		selectedId =[];
		listPage = $(this).closest('.donation-index');

		if($(this).find('input[name=options]').val() == 1){
			listPage.find('input[name="selection[]"]').each(function(){
				$(this).prop("checked", "checked");
				tr = $(this).closest('tr');
				if(tr.find('.link-sf').length > 0)
					$(this).removeProp('checked');	
			});
		}
		else
			listPage.find('input[name="selection[]"]').removeProp("checked");
		


		listPage.find('input[name="selection[]"]').each(function(index){
			if($(this).is(":checked"))
				selectedId.push($(this).val());
		});
	});
	$(this).on('change', 'input[name="selection[]"]', function(e){
		listPage = $(this).closest('.donation-index');
		tr = $(this).closest('tr');

		if(tr.find('.link-sf').length > 0)
		{
			$(this).removeProp('checked');
		}
		selectedId = [];
		listPage.find('input[name="selection[]"]').each(function(index){
			if($(this).is(":checked"))
				selectedId.push($(this).val());
		});
	});

	$('#modalConfirmUploadSf').on('shown.bs.modal', function (e) {
		$('#uploadToSf').show();
		button = $(e.relatedTarget);
		if(selectedId.length == 0)
		{
			$(this).find(".modal-body").html("No data selected.");
			$('#uploadToSf').hide();
		}
		else
		  	$(this).find(".modal-body").html(
		  		"<p>You are going to upload <strong>" + selectedId.length + "</strong> data into Salesforce. " + 
		  		"This means application will create " + selectedId.length + " new record(s) inside salesforce. <br />" + 
		  		"<strong>Do you want to proceed now?</strong></p>"
		  	);
		 if(button.data("url") != undefined)
			$('#uploadToSf').attr('href', BASEURL + button.data('url') + "?id=" +  encodeURIComponent(selectedId.join()));
	});

	$(this).on("click", "#uploadToSf", function(e){
		if($(this).attr('href') == '#')
			e.preventDefault();

		if(selectedId.length == 0)
			alert("No Donation Selected");
		else{
			location = BASEURL + "/donation/upload-to-sf?id=" +  encodeURIComponent("" + selectedId.join() + "");
		}

	});
	$('a[data-confirm]').click(function(ev) {
        var href = $(this).attr('href');
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $('#dataConfirmModal').modal({show:true});
        return false;
    });
})