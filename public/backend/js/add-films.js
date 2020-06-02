function addFilmContent() {
    return `<form id="test">
                <div>
                    <input type="text" placeholder="Film name" name="name" class="name form-control" />
                    <textarea placeholder="Film description" name="description" class="name form-control mt-2"></textarea>
                    <div class="mt-3 append-new-date-input">
                        <span class="">Add date film  <i class="far fa-calendar-plus add-new-date-line-film"></i></span>
                         <hr>
                    </div>
                </div>
            </form>`
}

var count = 0;

function addNewDate() {
    return `<div class="add-new-date">
                <div>
                  <input type="datetime-local" name="start_date[]" min="${new Date()}" class="form-control">
                </div>
                <div>
                  <input type="datetime-local" name="end_date[]" class="form-control ml-3">
                </div>
                <div>
                    <a><i class="fas fa-trash-alt remove-date-film-content"></i></a>
                </div>
            </div>`;
}

$(document).ready(function () {
    $(document).on('click', '.add-new-film', function () {
        $('#exampleModalCenter .modal-body div').remove()
        $('#exampleModalCenter #exampleModalLongTitle').text('New Film')
        $('#exampleModalCenter').modal('show')
        $('#exampleModalCenter .append-content-modal').append(addFilmContent())

    });
    $(document).on('click', '.remove-date-film-content', function () {
        let main = $(this).parents('.add-new-date');
        main.remove()
    });
    $(document).on('click', '.add-new-date-line-film', function () {
        $('#exampleModalCenter .modal-body .append-new-date-input').append(addNewDate())
    });
    $(document).on('click', '.click-save-add-or-update-film', function () {
        let form = $('#test').serializeArray();
        let valid = true;
        let dateArr = [];
        let formData = new FormData();
        $.each(form, function (i, item) {
            switch (item.name) {
                case 'name':
                    formData.append('name', item.value)
                    if (item.value.length === 0) {
                        $(`input[name=${item.name}]`).addClass('add-error-border')
                        valid = false
                    } else {
                        $(`input[name=${item.name}]`).removeClass('add-error-border')
                    }
                    break;
                case 'description':
                    formData.append('description', item.value)
                    break;
            }
            if (item.name === 'start_date[]' && form[i + 1].value.length > 0) {
                dateArr.push(item.value + ' - ' + form[i + 1].value)
            }
        });
        formData.append('date', JSON.stringify(dateArr));
        if (valid) {
            fetch(window.location.origin + '/admin/films', {
                headers: {
                    "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                },
                body: formData,
                method: 'POST'
            }).then(response => {
                return response.json();
            }).then((res) => {
                console.log(res);
            });
        }
    })
})
