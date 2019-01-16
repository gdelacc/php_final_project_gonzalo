$( document ).ready(function() {

	$('.client_add_btn').click(function () {
		var client_id = $(this).data('id');
		
		$("#client_id").val("");
		$("#client_name").val("");
		$("#client_lastname").val("");
		$("#client_phone").val("");
		$("#client_email").val("");
		$("#editModal").modal('show');
	});

	$('.client_edit_btn').click(function () {
		var client_id = $(this).data('id');
		
		$("#client_id").val(client_id);
		$("#client_name").val($(this).data('name'));
		$("#client_lastname").val($(this).data('lastname'));
		$("#client_phone").val($(this).data('phone'));
		$("#client_email").val($(this).data('email'));
		$("#editModal").modal('show');
	});

	$(".client_del_btn").click(function(){
		var client_id = $(this).data('id');
		if(client_id != "") {
			$.ajax({
				type: 'POST',
				url: "/delete_client",
				dataType: 'json',
				data: {
					client_id: client_id
				},
				success: function(resp) {
					if(resp.output == "success")
						location.reload();
				},
				error: function() {
					$("#error_msg").show();
				}
			});
		}
	});

	$("#client_form").submit(function(event) {
		event.preventDefault();
		var client_id = $("#client_id").val();
		if(client_id == "")
		{
			$.ajax({
				type: 'POST',
				url: "/add_new_client",
				dataType: 'json',
				data: {
					client_name: $("#client_name").val(),
					client_lastname: $("#client_lastname").val(),
					client_phone: $("#client_phone").val(),
					client_email: $("#client_email").val(),
				},
				success: function(resp) {
					if(resp.output == "success")
						location.reload();
				},
				error: function() {
					$("#error_msg").show();
				}
			});
		}
		else {
			$.ajax({
				type: 'POST',
				url: "/save_client",
				dataType: 'json',
				data: {
					client_id: client_id,
					client_name: $("#client_name").val(),
					client_lastname: $("#client_lastname").val(),
					client_phone: $("#client_phone").val(),
					client_email: $("#client_email").val()
				},
				success: function(resp) {
					if(resp.output == "success")
						location.reload();
				},
				error: function() {
					$("#error_msg").show();
				}
			});
		}
	});

    /*$("#car_list").DataTable({
        "columnDefs": [
            { "name": "car_brand", "targets": 0 },
            { "name": "car_model", "targets": 1 },
            { "name": "car_price", "targets": 2 },
            { "name": "car_inserted", "targets": 3 }
        ],
        // Server-side parameters
        "processing": true,
        "serverSide": true,
        // Ajax call
        "ajax": {
            "url": "{{ path('car_datatables') }}",
            "type": "POST"
        },
        // Classic DataTables parameters
        "paging" : true,
        "info" : true, 
        "searching": true,
        "pageLength": 10,
        "order": [[3, 'desc']]
    });
    */
});