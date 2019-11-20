$('#updateModal').on('show.bs.modal', function (event) {
    let _modal = $(this);
    let _wrapper = _modal.find('.modal-body');
    let url = $(event.relatedTarget).data('url');
    _wrapper.find('form').attr('action', url);

    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            _wrapper.find('form #product-name').val(data.name);
            _wrapper.find('form #product-price').val(data.price);

            _wrapper.find('form *').removeClass('has-error');
            _wrapper.find('form *').removeClass('has-success');
            _wrapper.find('form .help-block').html('');
        }
    });
});

$('#closeUpdateModal').on('click', function () {
    let _modal = $(this).closest('.modal');
    let _wrapper = _modal.find('.modal-body');

    let data = {
        'Product': {
            price: _wrapper.find('form #product-price').val()
        }
    };

    $.ajax({
        data: data,
        type: 'POST',
        url: _wrapper.find('form').attr('action'),
        success: function(data) {
            if (data) {
                $('#updateModal').modal('hide');
                $.pjax.reload({container: '#pjaxProduct'});
            }
        }
    });
});
