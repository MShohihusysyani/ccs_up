$(function () {
	$(".js-basic-example").DataTable({
		responsive: true,
	});

	//Exportable table
	$(".js-exportable").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: ["copy", "csv", "excel", "pdf", "print"],
	});

	$(".js-exportable-barang").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "csv",
				text: "Csv",
				exportOptions: {
					columns: [0, 1],
				},
			},
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [0, 1],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [0, 1],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [0, 1],
				},
			},
		],
	});

	$(".js-exportable-4").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "csv",
				text: "Csv",
				exportOptions: {
					columns: [0, 1, 2, 3],
				},
			},
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [0, 1, 2, 3],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [0, 1, 2, 3],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [0, 1, 2, 3],
				},
			},
		],
	});

	$(".js-exportable-3").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "csv",
				text: "Csv",
				exportOptions: {
					columns: [0, 1, 2],
				},
			},
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [0, 1, 2],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [0, 1, 2],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [0, 1, 2],
				},
			},
		],
	});

	$(".js-exportable-6").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "csv",
				text: "Csv",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5],
				},
			},
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5],
				},
			},
		],
	});

	$(".js-exportable-5").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "csv",
				text: "Csv",
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
			},
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [0, 1, 2, 3, 4],
				},
			},
		],
	});

	$(".js-exportable-17").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [
						0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
					],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [
						0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
					],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [
						0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,
					],
				},
			},
		],
	});

	$(".js-exportable-finish").DataTable({
		dom: "Bfrtip",
		responsive: true,
		buttons: [
			{
				extend: "excel",
				text: "Excel",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
				},
			},
			{
				extend: "pdf",
				text: "Pdf",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
				},
			},
			{
				extend: "print",
				text: "Print",
				exportOptions: {
					columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
				},
			},
		],
	});
});
