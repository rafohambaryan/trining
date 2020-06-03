$(document).ready(function () {
    $(document).on('click', '.logout-admin', function () {
        let form = $(this).parents('#logout-form')
        Swal.fire({
            title: 'Are you sure?',
            text: "Logout!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                form.submit();
            }
        })

    })
});
