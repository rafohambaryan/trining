function addFilmContent(name = '', description = '', data = [], id = 0, genre = []) {
    let date_film = '';
    let datePickerArray = [];
    $.each(data, function (i, item) {
        var dateRangePicker = addNewDate(item.start_date + ' - ' + item.end_date);
        date_film += dateRangePicker[0];
        datePickerArray.push(dateRangePicker[1])
    });
    let genreArr = [];
    $.each(genre, function (i, item) {
        genreArr.push(item.genre_id)
    });
    let genresHtml = '';
    for (let i = 0; i < genres.length; i++) {
        genresHtml += `<div class="checked-jquery-ui">
                           <label for="genre-${genres[i].id}">${genres[i].name}</label>
                           <input type="checkbox" name="genre[]" id="genre-${genres[i].id}" value="${genres[i].id}" ${genreArr.includes(genres[i].id) ? 'checked' : ''}>
                       </div>`;
    }
    let html = `<form class="form-update-or-create">
                <input type="hidden" value="${id}" name="film_id">
                <div>
                    <div class="genre-films">
                          ${genresHtml}
                        <hr>
                    </div>
                    <input type="text" placeholder="Film name" name="name" value="${name}" class="name form-control" />
                    <textarea placeholder="Film description" name="description" class="name form-control mt-2">${description}</textarea>
                    <div class="mt-3 append-new-date-input">
                        <span class="">Add date film  <i class="far fa-calendar-plus add-new-date-line-film"></i></span>
                         <hr>
                         ${date_film}
                    </div>
                </div>
            </form>`;
    return [html, datePickerArray];
}

function addNewDate(date = '') {
    let time = (new Date()).getTime() + Math.floor(Math.random() * 999999999999);
    let html = `<div class="add-new-date">
                      <div>
                        <input type="text" name="date-to-date[]" value="${date}" class="form-control data-picker-${time} date-picker-class-css" placeholder="change date ... ">
                      </div>

                      <div>
                          <a><i class="fas fa-trash-alt remove-date-film-content"></i></a>
                      </div>
                  </div>`;
    return [html, 'data-picker-' + time];
}

function printCheckedToms(res, code) {
    Swal.fire({
        title: '',
        html: `<div class="get-checked-data-admin">
                               <p>Film Name: <strong>${res.film}</strong> </p>
                               <p>From: <strong>${res.date.start}</strong></p>
                               <p>To: <strong>${res.date.end}</strong></p>
                               <p>Film Card: <strong>${res.card}</strong> </p>
                               <p>line: <strong>${res.line}</strong> chair: <strong>${res.chair}</strong> </p>
                           </div>`,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            fetch(window.location.origin + '/admin/card/' + code, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                },
                method: 'delete'
            }).then(response => {
                return response.json();
            }).then((res) => {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been deleted',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }
    });
    return true;
}

var app = new Map();
var click = true;
var httpGetGenre = new XMLHttpRequest();
httpGetGenre.open('GET', window.location.origin + '/genres', false);
httpGetGenre.send();
var genres = JSON.parse(httpGetGenre.response);
$(document).ready(function () {
    $('.dataPicker').dateRangePicker({
        startOfWeek: 'monday',
        separator: ' - ',
        format: 'YYYY.MM.DD HH:mm',
        autoClose: false,
        time: {
            enabled: true
        }
    }).bind('datepicker-change', function (event, object) {
        if (object.value.length === 35) {
            fetch(window.location.origin + `/search?date=${object.value}`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                },
                method: 'get'
            }).then(response => {
                return response.json();
            }).then((res) => {
                $('#dataTableFilmsList tbody tr').addClass('d-none');
                $.each(res,function (i,item) {
                    $(`#dataTableFilmsList tbody tr[data-id=${item}]`).removeClass('d-none');
                })
            });
        }
    })


    $('#dataTableFilmsList').DataTable();

    $(document).on('click', '.add-new-film', function () {
        if (click) {
            click = false;
            $('#exampleModalCenter .modal-body *').remove();
            $('#exampleModalCenter .modal-footer').removeClass('d-none');
            $('#exampleModalCenter #exampleModalLongTitle').text('New Film');
            $('#exampleModalCenter .append-content-modal').append(addFilmContent()[0]);
            $(".checked-jquery-ui input").checkboxradio();
            $('#exampleModalCenter').modal('show');
            setTimeout(function () {
                click = true;
            }, 300);
        }

    });
    $(document).on('click', '.remove-date-film-content', function () {
        let main = $(this).parents('.add-new-date');
        main.remove()
    });
    $(document).on('click', '.add-new-date-line-film', function () {
        if (click) {
            click = false;
            setTimeout(function () {
                click = true;
            }, 300);
            let datePicker = addNewDate();
            $('#exampleModalCenter .modal-body .append-new-date-input').append(datePicker[0])
            $(`.${datePicker[1]}`).dateRangePicker({
                startDate: new Date(),
                selectForward: true,
                startOfWeek: 'monday',
                separator: ' - ',
                format: 'YYYY.MM.DD HH:mm',
                autoClose: false,
                time: {
                    enabled: true
                },
                defaultTime: moment().startOf('day').toDate(),
                defaultEndTime: moment().endOf('day').toDate(),
            });
        }
    });
    $(document).on('click', '.click-save-add-or-update-film', function () {
        if (click) {
            click = false;
            setTimeout(function () {
                click = true;
            }, 300);
            let form = $('.form-update-or-create').serializeArray();
            let valid = true;
            let dateArr = [];
            var formData = new FormData();
            let film_id = 0;
            $.each(form, function (i, item) {
                switch (item.name) {
                    case 'genre[]':
                        formData.append('genre[]', item.value)
                        break;
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
                if (item.name === 'date-to-date[]' && item.value.length === 35) {
                    dateArr.push(item.value)
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
                                                                <td>${res.data.id}</td>
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
        }
    });
    $(document).on('click', '.delete-film', function () {
        if (click) {
            click = false;
            setTimeout(function () {
                click = true;
            }, 300);
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
        }
    });
    $(document).on('click', '.update-film', function () {
        if (click) {
            click = false;
            setTimeout(function () {
                click = true;
            }, 300);
            let parent = $(this).parents('.card-film-tr');
            $('#exampleModalCenter .modal-body *').remove()
            $('#exampleModalCenter .modal-footer').removeClass('d-none')
            fetch(window.location.origin + '/admin/films/' + parent.attr('data-id')).then(response => {
                return response.json();
            }).then((res) => {
                if (res.success) {
                    $('#exampleModalCenter #exampleModalLongTitle').html(`<span>Update <strong>(${res.data.name})</strong> Film</span>`)
                    let dateAppend = addFilmContent(res.data.name, res.data.description, res.data.get_date, res.data.id, res.data.get_genre)
                    $('#exampleModalCenter .append-content-modal').append(dateAppend[0]);
                    $.each(dateAppend[1], function (i, item) {
                        $(`.${item}`).dateRangePicker({
                            startDate: new Date(),
                            selectForward: true,
                            startOfWeek: 'monday',
                            separator: ' - ',
                            format: 'YYYY.MM.DD HH:mm',
                            autoClose: false,
                            time: {
                                enabled: true
                            },
                            defaultTime: moment().startOf('day').toDate(),
                            defaultEndTime: moment().endOf('day').toDate(),
                        })
                    })
                    $(".checked-jquery-ui input").checkboxradio();
                    $('#exampleModalCenter').modal('show')
                }
            });
        }

    });
    $(document).on('click', '.get-checked-film', function () {
        if (click) {
            click = false;
            setTimeout(function () {
                click = true;
            }, 300);
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
                        $('#exampleModalCenter .append-content-modal').append(`<form class="date_form_checked_list">
                                                                                <input type="hidden" id="set_date_id_admin" name="date_id" value="0">
                                                                                <input type="hidden" id="set_film_id_admin" name="film_id" value="${res.data.id}">
                                                                           </form>
                                                                           <select class="form-control form-control-lg get-checked-lists">
                                                                                <option disabled selected>selected Date</option>
                                                                           </select>
                                                                           <table class="costume_table"></table>`);
                        $.each(res.data.get_date, function (i, item) {
                            $('#exampleModalCenter .append-content-modal .get-checked-lists').append(`<option value="${item.id}">${item.start_date} to ${item.end_date}</option>`)
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
        }
    });
    $(document).on('change', '.get-checked-lists', function () {
        let date_id = $(this).val();
        $('.date_form_checked_list #set_date_id_admin').val(date_id);
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
            app.set('checked', res.checked);
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
                });
            })
        });
    });

    $(document).on('click', '.checked', function () {
        let date_id = $('.date_form_checked_list #set_date_id_admin').val();
        let line_id = $(this).attr('data-id');
        let table = $('.costume_table');
        fetch(window.location.origin + '/admin/get-checked', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
            },
            body: JSON.stringify({count_line_id: line_id, date_film_id: date_id}),
            method: 'post'
        }).then(response => {
            return response.json();
        }).then((res) => {
            if (res.success) {
                Swal.fire({
                    title: '',
                    html: `<div class="get-checked-data-admin">
                               <p>Film Name: <strong>${res.film}</strong> </p>
                               <p>From: <strong>${res.date.start}</strong></p>
                               <p>To: <strong>${res.date.end}</strong></p>
                               <p>Film Card: <strong>${res.card}</strong> </p>
                               <p>line: <strong>${res.line}</strong> chair: <strong>${res.chair}</strong> </p>
                           </div>`,
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        fetch(window.location.origin + '/admin/card/' + res.card, {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                            },
                            method: 'delete'
                        }).then(response => {
                            return response.json();
                        }).then((res) => {
                            if (res.success) {
                                table.find(`td[data-id=${line_id}]`).addClass('no-checked').removeClass('checked')
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Your work has been deleted',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        });
                    }
                });

            } else {
                table.find('td').addClass('no-checked')
                $.alert('Error')
                $.each(app.get('checked'), function (i, item) {
                    $.each(item, function (j, count) {
                        table.find(`td[data-id=${count}]`).removeClass('no-checked').addClass('checked')
                    });
                });
            }
        });
    });
    $(document).on('click', '.no-checked', function () {
        let date_id = $('.date_form_checked_list #set_date_id_admin').val();
        let film_id = $('.date_form_checked_list #set_film_id_admin').val();
        let line_id = $(this).attr('data-id')
        let _this = $(this);
        let table = $('.costume_table');
        $.confirm({
            title: 'Attention!',
            content: 'you buy new toms',
            buttons: {
                somethingElse: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () {
                        fetch(window.location.origin + '/checked', {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
                            },
                            body: JSON.stringify({film: film_id, date: date_id, count: line_id}),
                            method: 'post'
                        }).then(response => {
                            return response.json();
                        }).then((res) => {
                            if (res.success) {
                                _this.removeClass('no-checked').addClass('checked');
                                Swal.fire({
                                    title: 'ticket number',
                                    html: `<strong>${res.card}</strong>`,
                                });

                            } else {
                                table.find('td').addClass('no-checked')
                                $.each(app.get('checked'), function (i, item) {
                                    $.each(item, function (j, count) {
                                        table.find(`td[data-id=${count}]`).removeClass('no-checked').addClass('checked')
                                    });
                                });
                                $.alert('Error')
                            }
                        });
                    }
                },
                cancel: function () {
                    return true;
                },
            }
        });
    });
    $(document).on('click', '.get-checked-film-card', function () {

        $.confirm({
            title: '',
            content: '' +

                '<div class="form-group">' +
                '<label>Film code</label>' +
                '<input type="text" placeholder="Your code" class="code form-control" required />' +
                '</div>',
            buttons: {
                formSubmit: {
                    text: 'Search',
                    btnClass: 'btn-blue',
                    action: function () {
                        let code = this.$content.find('.code').val();
                        if (!code) {
                            return false;
                        }
                        fetch(window.location.origin + '/admin/card/' + code).then(response => {
                            if (response.status === 200)
                                return response.json();
                            return {'success': false};
                        }).then((res) => {
                            if (res.success) {
                                printCheckedToms(res, code)
                            } else {
                                Swal.fire('Film card not fount')
                            }
                        });
                    }
                },
                cancel: function () {
                    return true;
                },
            },
        });
    });
});
