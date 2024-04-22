//tombol hapus
$(".tombol-usulkan").on("click", function (e) {
	e.preventDefault(); //matikan fungsi href nya terlebih dahulu dengan event

	const href = $(this).attr("href"); //kita ambil attribute dari html yang mau kita jadikan flashmassage disini adalah attribut href(link)

	new Swal({
		title: "Forward CCS?",
		text: "Data akan diforward!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Forward!",
	}).then((result) => {
		if (result.value) {
			document.location.href = href; //kembalikan nilai true dengan redirect document ke halaman yang dituju
		}
	});
});

// const setuju = $('.setuju').data('setuju');

// if (setuju) {
// 	new Swal({
// 		title: 'Success',
// 		text: setuju,
// 		icon: 'success',
// 		html: '<a href="<?= base_url();?>/pengajuan/detpengajuan">Klik Untuk Melihat Rekap Pengajuan</a> ',
// 		showCloseButton: true,
// 		showConfirmButton: true
// 	});
// }
