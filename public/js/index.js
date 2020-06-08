function select(_class, name, id, text) {
    return `<div class="${_class}">
                   <select name="${name}" id="${id}" class="form-control form-control-lg">
                        <option disabled selected>${text}</option>
                   </select>
               </div>`;
}

function ajax(method, url, data = new FormData()) {
    let http = new XMLHttpRequest();
    http.open(method, window.location.origin + url, false);
    http.setRequestHeader("X-CSRF-Token", document.getElementsByName('csrf_token')[0].content);
    http.send(data)
    return JSON.parse(http.response);
}

var app = new Map();
var http = new FormData();
$(document).ready(function () {
    var table = $('.costume_table');
    let main = $('.films-content');
    $(document).on('change', '#films_all', function () {
        let film_id = $(this).val();
        http.append('film_id', film_id)
        let res = ajax('post', '', http);
        if (res) {
            table.find('td').removeClass('no-checked').removeClass('checked');
            main.find('div').remove();
            http = new FormData();
            if (res.success) {
                main.append(select('film-date', 'date', 'film_date_select', 'Selected Date'))
                $.each(res.data, function (i, item) {
                    $('.film-date select').append(`<option value="${item.id}">${(new Date(item.start_date)).toLocaleString()} - ${(new Date(item.end_date)).toLocaleString()}</option>`);
                });
            }
        }
    });
    $(document).on('change', '#film_date_select', function () {
        let date_id = $(this).val();
        http.append('date_id', date_id);
        let res = ajax('POST', '/date', http);
        if (res) {
            http = new FormData();
            main.find('.film-checked-lines').remove();
            main.find('.film-checked-lines-count').remove();
            app.set('checked', []);
            table.find('td').removeClass('no-checked').removeClass('checked')
            if (res.success) {
                table.find('td').addClass('no-checked')
                $.each(res.checked, function (i, item) {
                    $.each(item, function (j, count) {
                        console.log(table.find(`td[data-id=${count}]`))
                        table.find(`td[data-id=${count}]`).removeClass('no-checked').addClass('checked')
                    })
                })
                app.set('checked', res.checked);
            }
        }
    });
    $(document).on('change', '#film_checked_lines_select', function () {
        let counter = $('.film-checked-lines-count');
        counter.removeClass('d-none');
        let line_id = $(this).val();
        counter.find('option').addClass('d-none');
        $.each(counter.find('option'), function (i, item) {
            if ($(item).attr('data-line-id') === line_id) {
                $(item).removeClass('d-none');
            }
        });
        counter.find(`option`).removeAttr('disabled').removeClass('checked_option');
        $.each(app.get('checked')[line_id], function (i, item) {
            counter.find(`option[value=${item}]`).attr('disabled', 'disabled').addClass('checked_option');
        });
    });

    $(document).on('change', '#film-checked-lines-count', function () {
        let form = $('#checked_film_form').serializeArray();
        $.each(form, function (i, item) {
            http.append(item.name, item.value)
        });
        console.log(form);
        $.confirm({
            title: 'Attention!',
            content: 'you buy new toms',
            buttons: {
                somethingElse: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () {
                        let res = ajax('POST', '/checked', http);
                        if (res) {
                            http = new FormData();
                            if (res.success) {
                                main.find('div').remove();
                                $('#films_all option').removeAttr('selected');
                                $('#films_all .default_selected').attr({
                                    'selected': 'selected',
                                    'disabled': 'disabled',
                                });
                                $.alert({
                                    'title': 'toms number:',
                                    content: res.card
                                });
                            }
                        }
                    }
                },
                cancel: function () {
                    return true;
                },
            }
        });
    });
    $(document).on('click', '.no-checked', function () {
        let count_id = $(this).attr('data-id');
        let _this = $(this);
        http.append('count', count_id)
        let form = $('#checked_film_form').serializeArray();
        $.each(form, function (i, item) {
            if (item.name === 'count') {
                return false;
            }
            http.append(item.name, item.value)
        });
        $.confirm({
            title: 'Attention!',
            content: 'you buy new toms',
            buttons: {
                somethingElse: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () {
                        let res = ajax('POST', '/checked', http);
                        if (res) {
                            http = new FormData();
                            if (res.success) {
                                _this.removeClass('no-checked').addClass('checked')
                                $.alert({
                                    'title': 'toms number:',
                                    content: res.card
                                });
                            } else {
                                table.find('td').addClass('no-checked')
                                $.each(app.get('checked'), function (i, item) {
                                    $.each(item, function (j, count) {
                                        console.log(table.find(`td[data-id=${count}]`))
                                        table.find(`td[data-id=${count}]`).removeClass('no-checked').addClass('checked')
                                    })
                                })
                                $.alert('Error')
                            }
                        }
                    }
                },
                cancel: function () {
                    return true;
                },
            }
        });


    })
})
