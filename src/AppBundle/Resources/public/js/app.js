/*! app.js - v1.0*/

var App = function() {
    var options;

    var initStartButton = function() {
        $('#startBtn').click(function(e) {
            $('#cases, #startBtn').prop('disabled','disabled');
            $.ajax({
                type: "POST",
                url: options.URL_SENDCASES,
                dataType: 'json',
                data: {cases: $('#cases').prop('value')}
            }).done(function(resp) {console.debug(resp);

                if(resp.success){
                    $('#startBtn').prop('disabled','');
                    $('#startBtn').html('Reiniciar');
                    $('#startBtn').removeClass('btn-primary');
                    $('#startBtn').addClass('btn-danger');
                }

            }).error(function(jqXHR, textStatus, errorThrown){
                $('#modal_msg .modal-title').html(textStatus);
                $('#modal_msg .modal-body').html(errorThrown);
                $('#modal_msg').modal('show');
            })
        });
    }



    return {
        init: function(opts) {

            var defaults = {

            };
            options = $.extend({}, defaults, opts);

            $('input').popover();

            initStartButton();
        }
    }
}();

