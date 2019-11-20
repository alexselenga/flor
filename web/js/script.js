$('.modal').on('show.bs.modal', function (event) {
    let _form = $(this).find('form');
    let url = $(event.relatedTarget).data('url');
    _form.attr('action', url);

    $.ajax({
        url: url,
        type: 'GET',
        success: function(fields) {
            for (let fieldName in fields) {
                _form.find('#product-' + fieldName).val(fields[fieldName]);
            }

            _form.find('*').removeClass('has-error has-success');
            _form.find('.help-block').html('');
        }
    });
});

$('#closeModal').on('click', function () {
    let _modal = $(this).closest('.modal');
    let _form = _modal.find('form');

    $.ajax({
        url: _form.attr('action'),
        type: 'POST',
        data: _form.serialize(),
        success: function(saved) {
            if (saved) {
                _modal.modal('hide');
                $.pjax.reload({container: '#pjaxProduct'});
            }
        }
    });
});

$('.modal').keydown(function (e) {
    if (e.which == 13) {
        $(this).find('#closeModal').click();
    }
});
