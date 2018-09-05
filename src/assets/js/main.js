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

function swalSuccess() {
	const toast = swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 5000
	  });
	  
	  toast({
		type: 'success',
		title: 'Data berhasil disimpan'
	  })
}

function swalDeleted() {
	const toast = swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 5000
	  });
	  
	  toast({
		type: 'success',
		title: 'Data berhasil dihapus'
	  })
}