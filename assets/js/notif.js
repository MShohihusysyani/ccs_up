const notif = $('.notif').data('notif');

if (notif) {
	new Swal({
		title: 'Success',
		text: notif,
		icon: 'success',
		showCloseButton: true,
		showConfirmButton: false
	});
}
