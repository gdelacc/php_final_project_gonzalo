$( document ).ready(function() {

	$("#rental_start_date").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#rental_end_date").datepicker({
		dateFormat: "yy-mm-dd"
	});

	$('.rental_add_btn').click(function () {
		$("#rental_id").val("");
		$("#rental_clientid").val("");
		$("#rental_carid").val("");
		$("#rental_price").val("");
		$("#rental_start_date").val("");
		$("#rental_end_date").val("");
		$("#rentalEditModal").modal('show');
	});

	$('.rental_edit_btn').click(function () {
		var rental_id = $(this).data('id');
		
		$("#rental_id").val(rental_id);
		$("#rental_clientid").val($(this).data('clientid'));
		$("#rental_carid").val($(this).data('carid'));
		$("#rental_price").val($(this).data('price'));
		$("#rental_start_date").val(($(this).data('startdate').split(" "))[0]);
		$("#rental_end_date").val(($(this).data('enddate').split(" "))[0]);
		$("#rentalEditModal").modal('show');
	});

	$(".rental_del_btn").click(function(){
		var rental_id = $(this).data('id');
		if(rental_id != "") {
			$.ajax({
				type: 'POST',
				url: "/delete_rental",
				dataType: 'json',
				data: {
					rental_id: rental_id
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

	$("#rental_form").submit(function(event) {
		event.preventDefault();
		var rental_id = $("#rental_id").val();
		var rental_start_date = $("#rental_start_date").val();
		var rental_end_date = $("#rental_end_date").val();
		if(rental_id == "")
		{
			$.ajax({
				type: 'POST',
				url: "/add_new_rental",
				dataType: 'json',
				data: {
					rental_clientid: $("#rental_clientid").val(),
					rental_carid: $("#rental_carid").val(),
					rental_price: $("#rental_price").val(),
					rental_start_date: rental_start_date,
					rental_end_date: rental_end_date
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
				url: "/save_rental",
				dataType: 'json',
				data: {
					rental_id: rental_id,
					rental_clientid: $("#rental_clientid").val(),
					rental_carid: $("#rental_carid").val(),
					rental_price: $("#rental_price").val(),
					rental_start_date: rental_start_date,
					rental_end_date: rental_end_date
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