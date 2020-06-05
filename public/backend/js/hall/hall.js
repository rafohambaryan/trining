$(document).ready(function () {
    var modal = $('#hallModalCenter')
    $(document).on('click', '.add-new-line-hall', function () {
        modal.find('.append-content-modal *').remove();
        modal.modal('show');
    });
    $(document).on('click', '.line-delete', function () {
        let parent = $(this).parents('.line-halls-line');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                parent.remove();
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been deleted',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    })


});
