function addFilmContent(name = '', description = '', data = [], id = 0) {
    let date_film = '';
    $.each(data, function (i, item) {
        date_film += addNewDate(item.start_date, item.end_date)
    })
    return `<form class="form-update-or-create">
                <input type="hidden" value="${id}" name="film_id">
                <div>
                    <input type="text" placeholder="Film name" name="name" value="${name}" class="name form-control" />
                    <textarea placeholder="Film description" name="description" class="name form-control mt-2">${description}</textarea>
                    <div class="mt-3 append-new-date-input">
                        <span class="">Add date film  <i class="far fa-calendar-plus add-new-date-line-film"></i></span>
                         <hr>
                         ${date_film}
                    </div>
                </div>
            </form>`
}

function addNewDate(start = '', end = '') {
    var d = (new Date(start)).toLocaleString();
    return `<div class="add-new-date">
                <div>
                  <input type="datetime-local" name="start_date[]" value="${start}" class="form-control">
                </div>
                <div>
                  <input type="datetime-local" name="end_date[]" value="${end}" class="form-control ml-3">
                </div>
                <div>
                    <a><i class="fas fa-trash-alt remove-date-film-content"></i></a>
                </div>
            </div>`;
}

$(document).ready(function () {
    $(document).on('click', '.add-new-film', function () {
        $('#exampleModalCenter .modal-body *').remove()
        $('#exampleModalCenter .modal-footer').removeClass('d-none')
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
        let form = $('.form-update-or-create').serializeArray();
        let valid = true;
        let dateArr = [];
        var formData = new FormData();
        let film_id = 0;
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
                case 'film_id':
                    film_id = item.value
                    break;
            }
            if (item.name === 'start_date[]' && form[i + 1].value.length > 0) {
                dateArr.push(item.value + ' - ' + form[i + 1].value)
            }
        });
        formData.append('date', JSON.stringify(dateArr));
        if (valid) {
            fetch(window.location.origin + '/admin/films/' + film_id, {
                headers: {
                    "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                },
                body: formData,
                method: 'POST'
            }).then(response => {
                return response.json();
            }).then((res) => {
                if (res.success) {
                    if (film_id > 0) {
                        let content = $(`#dataTableFilmsList tbody .card-film-tr[data-id=${film_id}]`)
                        content.addClass('bg-green')
                        content.find('.name').text(res.data.name);
                        content.find('.description').text(res.data.description ? res.data.description : '');
                    } else {
                        $('#dataTableFilmsList tbody').prepend(`<tr class="card-film-tr bg-green" data-id="${res.data.id}">
                                                                <td class="name">${res.data.name}</td>
                                                                <td class="description">${res.data.description ? res.data.description : ''}</td>
                                                                <td>
                                                                    <div class="crud-costume">
                                                                        <i class="fas fa-tasks get-checked-film"></i>
                                                                        <i class="fas fa-edit update-film"></i>
                                                                        <i class="fas fa-trash-alt delete-film"></i>
                                                                    </div>
                                                                </td>
                                                            </tr>`);
                    }
                    $('#exampleModalCenter').modal('hide');
                    setTimeout(function () {
                        $('#dataTableFilmsList tbody .card-film-tr').removeClass('bg-green');
                    }, 1500)
                }
            });
        }
    });
    $(document).on('click', '.delete-film', function () {
        let parent = $(this).parents('.card-film-tr')
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
                fetch(window.location.origin + '/admin/films/delete', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                    },
                    body: JSON.stringify({film_id: parent.attr('data-id')}),
                    method: 'delete'
                }).then(response => {
                    return response.json();
                }).then((res) => {
                    if (res.success) {
                        parent.remove();
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been deleted',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }
        });
    });
    $(document).on('click', '.update-film', function () {
        let parent = $(this).parents('.card-film-tr');
        $('#exampleModalCenter .modal-body *').remove()
        $('#exampleModalCenter .modal-footer').removeClass('d-none')
        fetch(window.location.origin + '/admin/films/' + parent.attr('data-id')).then(response => {
            return response.json();
        }).then((res) => {
            if (res.success) {
                $('#exampleModalCenter #exampleModalLongTitle').text('Update Film')
                $('#exampleModalCenter').modal('show')
                $('#exampleModalCenter .append-content-modal').append(addFilmContent(res.data.name, res.data.description, res.data.get_date, res.data.id))
            }
        });

    });
    $(document).on('click', '.get-checked-film', function () {
        let parent = $(this).parents('.card-film-tr');
        $('#exampleModalCenter .modal-body *').remove()
        $('#exampleModalCenter .modal-footer').addClass('d-none')
        fetch(window.location.origin + '/admin/films/' + parent.attr('data-id')).then(response => {
            return response.json();
        }).then((res) => {
            if (res.success) {
                if (res.data.get_date.length > 0) {
                    $('#exampleModalCenter #exampleModalLongTitle').html(`<span>get checked film (${res.data.name}) </span>`);
                    $('#exampleModalCenter').modal('show');
                    $('#exampleModalCenter .append-content-modal').append(`<form> <input type="hidden" name="film_id" value="${res.data.id}"> </form><select class="form-control form-control-lg get-checked-lists"><option disabled selected>selected Date</option></select><table class="costume_table"></table>`);
                    $.each(res.data.get_date, function (i, item) {
                        $('#exampleModalCenter .append-content-modal .get-checked-lists').append(`<option value="${item.id}">${(new Date(item.start_date)).toLocaleString()} to ${(new Date(item.end_date)).toLocaleString()}</option>`)
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'film date not fount',
                    });
                }
            }
        });
    });
    $(document).on('change', '.get-checked-lists', function () {
        let date_id = $(this).val();
        fetch(window.location.origin + '/date', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
            },
            body: JSON.stringify({date_id: date_id}),
            method: 'post'
        }).then(response => {
            return response.json();
        }).then((res) => {
            let tableContent = $('#exampleModalCenter .append-content-modal .costume_table');
            tableContent.find('tr').remove();
            $.each(res.lines, function (i, line) {
                var td = '';
                $.each(line.counter, function (j, counter) {
                    td += `<td class="no-checked" data-id="${counter.id}">${counter.order}</td>`
                });
                tableContent.append(`<tr>
                                          <th>${line.name} N ${line.order}</th>
                                          ${td}
                                     </tr>`)
            });

            $.each(res.checked, function (i, item) {
                $.each(item, function (j, count) {
                    tableContent.find(`td[data-id=${count}]`).removeClass('no-checked').addClass('checked')
                })
            })

            console.log(res)
        });
    })
})
