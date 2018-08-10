function showLoading() {
	$("body").LoadingOverlay("show", {
		image: env('loading_path_img'),
	});
}
function hideLoading() {
	$("body").LoadingOverlay("hide", true);
}

function removeClassModal() {
	$('.modal-dialog').removeClass('modal-full');
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').removeClass('modal-md');
	$('.modal-dialog').removeClass('modal-sm');
}