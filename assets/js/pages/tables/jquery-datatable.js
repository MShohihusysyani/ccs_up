$(function () {
	$('.js-basic-example').DataTable({
		responsive: true
	});

	//Exportable table
	$('.js-exportable').DataTable({
		dom: 'Bfrtip',
		responsive: true,
		buttons: [
			'copy', 'csv', 'excel', 'pdf',
			{
				extend: 'print',
				text: 'Print all (not just selected)',
				exportOptions: {
					columns: [0, 1]
				}
			}

		]
	});

	$('.js-exportable1').DataTable({
		dom: 'Bfrtip',
		responsive: true,
		buttons: [
			'copy', 'csv', 'excel', 'pdf',
			{
				extend: 'print',
				text: 'Print all (not just selected)',
				exportOptions: {
					columns: [0, 1]
				}
			}

		]
	});
});
