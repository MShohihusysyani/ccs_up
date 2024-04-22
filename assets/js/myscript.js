const flashData = $('.flash-data').data('flashdata');

if (flashData) {
	new Swal({
		title: 'Success',
		text: flashData,
		icon: 'success',
		showConfirmButton: true
	});
}





//tombol hapus
$('.tombol-hapus').on('click', function (e) {

	e.preventDefault(); //matikan fungsi href nya terlebih dahulu dengan event

	const href = $(this).attr('href'); //kita ambil attribute dari html yang mau kita jadikan flashmassage disini adalah attribut href(link)

	new Swal({
		title: 'Apakah anda yakin?',
		text: "Data yang dihapus tidak bisa dikembalikan!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Hapus Data!'
	}).then((result) => {
		if (result.value) {
			document.location.href = href; //kembalikan nilai true dengan redirect document ke halaman yang dituju
		}
	})

});


//tombol hapus
$('.tombol-aktif').on('click', function (e) {

	e.preventDefault(); //matikan fungsi href nya terlebih dahulu dengan event

	const href = $(this).attr('href'); //kita ambil attribute dari html yang mau kita jadikan flashmassage disini adalah attribut href(link)

	new Swal({
		title: 'Apakah anda yakin?',
		text: "Akun ini akan Di Aktifkan",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aktifkan Akun!'
	}).then((result) => {
		if (result.value) {
			document.location.href = href; //kembalikan nilai true dengan redirect document ke halaman yang dituju
		}
	})

});

$('.tombol-nonaktif').on('click', function (e) {

	e.preventDefault(); //matikan fungsi href nya terlebih dahulu dengan event

	const href = $(this).attr('href'); //kita ambil attribute dari html yang mau kita jadikan flashmassage disini adalah attribut href(link)

	new Swal({
		title: 'Apakah anda yakin?',
		text: "Akun ini akan Di Non-Aktifkan",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Non-Aktifkan Akun!'
	}).then((result) => {
		if (result.value) {
			document.location.href = href; //kembalikan nilai true dengan redirect document ke halaman yang dituju
		}
	})

});
