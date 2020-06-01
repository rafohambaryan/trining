$(document).ready(function () {
    let main = $('.films-content');
    let countRun = true;
    $(document).on('change', '#films_all', function () {
        let film_id = $(this).val();
        fetch(window.location.origin, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
            },
            method: 'POST',
            body: JSON.stringify({film_id: film_id}),
        }).then(response => {
            return response.json();
        }).then((res) => {
            main.find('div').remove();
            if (res.success) {
                main.append('<div class="film-date"><select class="form-control form-control-lg" name="date" id="film_date_select"><option disabled selected>Selected Date</option></select></div>')
                $.each(res.data, function (i, item) {
                    $('.film-date select').append(`<option value="${item.id}">${item.start_date} - ${item.end_date}</option>`);
                });
            }
        });
    });
    $(document).on('change', '#film_date_select', function () {
        let date_id = $(this).val();
        fetch(window.location.origin + '/date', {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": $('meta[name="csrf_token"]').attr('content')
            },
            method: 'POST',
            body: JSON.stringify({date_id: date_id}),
        }).then(response => {
            return response.json();
        }).then((res) => {
            main.find('.film-checked-lines').remove();
            main.find('.film-checked-lines-count').remove();
            if (res.success) {
                main.append('<div class="film-checked-lines"><select class="form-control form-control-lg" name="line" id="film_checked_lines_select"><option disabled selected>Selected Lines</option></select></div>')
                main.append('<div class="film-checked-lines-count d-none"><select class="form-control form-control-lg" name="count" id="film-checked-lines-count"><option disabled selected>Selected Chair</option></select></div>')

                $.each(res.lines, function (i, item) {
                    $('.film-checked-lines select').append(`<option value="${item.id}">${item.name} - ${item.order}</option>`);
                    $.each(item.counter, function (j, count) {
                        $('.film-checked-lines-count select').append(`<option value="${count.id}" data-line-id="${item.id}" class="d-none">${count.order}</option>`);
                    })
                });
                if (countRun || 1) {
                    $(document).on('change', '#film_checked_lines_select', function () {
                        let counter = $('.film-checked-lines-count');
                        counter.removeClass('d-none');
                        let line_id = $(this).val();
                        counter.find('option').addClass('d-none');
                        $.each(counter.find('option'), function (i, item) {
                            if ($(item).attr('data-line-id') === line_id) {
                                $(item).removeClass('d-none');
                            }
                        })
                        counter.find(`option`).removeAttr('disabled').removeClass('checked_option')
                        $.each(res.checked[line_id], function (i, item) {
                            counter.find(`option[value=${item}]`).attr('disabled', 'disabled').addClass('checked_option')
                        })
                    });
                    countRun = false;
                }
            }
        });
    });
    $(document).on('change', '#film-checked-lines-count', function () {
        let form = $('#checked_film_form').serializeArray();
        console.log(form)
        $.confirm({
            title: 'Confirm!',
            content: 'Simple confirm!',
            buttons: {
                somethingElse: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () {
                        main.find('div').remove();
                        $.alert('ok');
                        $('#films_all option').removeAttr('selected');
                        $('#films_all .default_selected').attr({
                            'selected': 'selected',
                            'disabled': 'disabled',
                        });
                    }
                },
                cancel: function () {
                    return true;
                },
            }
        });
    })
})
