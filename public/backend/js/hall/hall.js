$(document).ready(function () {
    var  modal = $('#hallModalCenter')
    $(document).on('click', '.add-new-line-hall', function () {
        modal.find('.append-content-modal *').remove();
        modal.modal('show');
    })

});
