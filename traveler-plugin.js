jQuery(document).ready(function ($) {
  (function ($) {
    $.fn.STSendAjax = function (type) {
        this.each(function () {
            var me = $(this);
            var button = $('.btn-register-visa-submit', this);
            if (type == 'register_insurance') {
                var button = $('.btn-register-insurance-submit', this);
            }
            var data = me.serializeArray();
            data.push({name: 'action', value: 'register_visa_form_direct_submit'});
            if (type == 'register_insurance') {
                data.push({name: 'action', value: 'register_insurance_form_direct_submit'});
            }
            me.find('.form-control').removeClass('error');
            me.find('.form_alert').addClass('hidden');
            var dataobj = {};
            for (var i = 0; i < data.length; ++i) {
                dataobj[data[i].name] = data[i].value
            }
            var validate = st_validate_checkout(me);
            if (!validate)
                return !1;
            button.addClass('loading');

            $.ajax({
                type: 'post',
                url: st_params.ajax_url,
                data: dataobj,
                dataType: 'json',
                success: function (data) {
                    if (data.message ) {
                        var message = data.message;
                        me.find('.form_alert').addClass('alert-danger').removeClass('hidden');
                        var htmlError = '<ul>';
                        for (var item in message) {
                            htmlError += '<li>' + message[item] + '</li>';
                        }
                        htmlError += '</ul>';
                        me.find('.form_alert').html(htmlError)
                    }
                    if (data.redirect) {
                        window.location.href = data.redirect
                    }
                    if (data.redirect_form) {
                        $('body').append(data.redirect_form)
                    }
                    if (data.new_nonce) {

                    }
                    button.removeClass('loading')
                },
                error: function (e) {
                    button.removeClass('loading');
                    alert('Lost connect to server');
                }
            });
        });
    };
  })(jQuery);

  $('input.traveler_plugin_date').datepicker({
    todayHighlight: true,
    autoclose: true,
    format: $('[data-date-format]').data('date-format'),
    weekStart: 1,
    setRefresh: true
  });

  $('.btn-register-visa-submit').click(function () {
    var form = $(this).closest('form');
    form.STSendAjax('register_visa');
  });

  $('.btn-register-insurance-submit').click(function () {
    var form = $(this).closest('form');
    form.STSendAjax('register_insurance');
  });

  function st_validate_checkout(me) {
    me.find('.form_alert').addClass('hidden');
    var data = me.serializeArray();
    var dataobj = {};
    var form_validate = !0;
    for (var i = 0; i < data.length; ++i) {
        dataobj[data[i].name] = data[i].value
    }
    me.find('input.required,select.required,textarea.required').removeClass('error');
    me.find('input.required,select.required,textarea.required').each(function () {
        if (!$(this).val()) {
            $(this).addClass('error');
            form_validate = !1
        }
    });
    if (form_validate == !1) {
        me.find('.form_alert').addClass('alert-danger').removeClass('hidden');
        me.find('.form_alert').html(st_checkout_text.validate_form);
        return !1
    }
    if (!dataobj.term_condition && $('[name=term_condition]', me).length) {
        me.find('.form_alert').addClass('alert-danger').removeClass('hidden');
        me.find('.form_alert').html(st_checkout_text.error_accept_term);
        return !1
    }
    return !0
  }
});