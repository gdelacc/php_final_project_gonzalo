$( document ).ready(function() {

	$('.car_add_btn').click(function () {
		var car_id = $(this).data('id');
		
		$("#car_id").val("");
		$("#car_model").val("");
		$("#car_price").val("");
		$("#editModal").modal('show');
	});

	$('.car_edit_btn').click(function () {
		var car_id = $(this).data('id');
		
		$("#car_id").val(car_id);
		$("#car_brand").val($(this).data('brand'));
		$("#car_model").val($(this).data('model'));
		$("#car_price").val($(this).data('price'));
		$("#editModal").modal('show');
	});

	$(".car_del_btn").click(function(){
		var car_id = $(this).data('id');
		if(car_id != "") {
			$.ajax({
				type: 'POST',
				url: "/delete_car",
				dataType: 'json',
				data: {
					car_id: car_id
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

	$("#car_form").submit(function(event) {
		event.preventDefault();
		var car_id = $("#car_id").val();
		if(car_id == "")
		{
			$.ajax({
				type: 'POST',
				url: "/add_new_car",
				dataType: 'json',
				data: {
					car_brand: $("#car_brand").val(),
					car_model: $("#car_model").val(),
					car_price: $("#car_price").val()
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
				url: "/save_car",
				dataType: 'json',
				data: {
					car_id: car_id,
					car_brand: $("#car_brand").val(),
					car_model: $("#car_model").val(),
					car_price: $("#car_price").val()
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