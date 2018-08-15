function showLoadingMenu() {
	$("body").LoadingOverlay("show", {
		image: '/assets/images/loading.gif',
	});
}
function hideLoadingMenu() {
	$("body").LoadingOverlay("hide", true);
}

function removeClassModal() {
	$('.modal-dialog').removeClass('modal-full');
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').removeClass('modal-md');
	$('.modal-dialog').removeClass('modal-sm');
}