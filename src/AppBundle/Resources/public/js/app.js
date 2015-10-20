/*! app.js - v1.0*/

var App = function() {
    var options;

    var regenerate = function() {
        $.ajax({
            type: "POST",
            url: options.URL_REGENERATE,
            dataType: 'json'
        }).done(function(resp) {
            if(resp.success){
                $('#startBtn').html('Reiniciar');
                $('#startBtn').removeClass('btn-primary');
                $('#startBtn').addClass('btn-danger');
                $('#operation_area').css('display','block');
                $('#operation_area_current').html(resp.operCurrent);
                $('#operation_area_total').html(resp.lastM);
                $('#testcase_current').html(resp.caseCurrent);
                $('#testcase_total').html(resp.caseTotal);
                $('#cases').prop('value', resp.caseTotal);
                $('#cases').prop('disabled', 'disabled');
                $('#size').prop('value', resp.lastN);
                $('#operations').prop('value', resp.lastM);
                $('#size,#operations,#startOperationBtn').prop('disabled', 'disabled');
                if(resp.caseCurrent <= resp.caseTotal){
                    $('#testcase').css('display','block');
                    if(resp.operCurrent > resp.lastM){
                        $('#operation_area_current,#operation_area_total').html('');
                        $('#operation_area').css('display','none');
                        $('#size,#operations,#startOperationBtn').prop('disabled', '');
                        $('#size,#operations').prop('value', '');
                        if(resp.caseCurrent < resp.caseTotal){
                            $('#testcase_current').html(resp.caseCurrent+1);
                        }
                    }

                }

                $.each(resp.logs, function( index, value ) {
                    $('#body_result').append('<tr><td>'+value.testCase+'</td><td>'+value.operation+'</td><td>'+value.result+'</td></tr>');
                });
            }
        }).error(function(jqXHR, textStatus, errorThrown){
            showModal(textStatus,errorThrown);
        });

    }

    var initStartButton = function() {
        $('#startBtn').click(function(e) {
            $('#cases, #startBtn').prop('disabled','disabled');
            $.ajax({
                type: "POST",
                url: e.target.innerText == "Iniciar Prueba" ? options.URL_SENDCASES : options.URL_RESET,
                dataType: 'json',
                data: {cases: $('#cases').prop('value')}
            }).done(function(resp) {
                if(e.target.innerText == "Reiniciar" && resp.success)
                    document.location = options.BASEPATH;
                if(resp.success){
                    $('#startBtn').html('Reiniciar');
                    $('#startBtn').removeClass('btn-primary');
                    $('#startBtn').addClass('btn-danger');
                    $('#testcase').css('display','block');
                    $('#testcase_current').html(resp.current);
                    $('#testcase_total').html(resp.total);
                }
                else{
                    $('#startBtn').html('Iniciar Prueba');
                    $('#startBtn').removeClass('btn-danger');
                    $('#startBtn').addClass('btn-primary');
                    $('#testcase').css('display','none');
                    $('#cases').prop('disabled','');
                    $('#testcase_current').html('');
                    $('#testcase_total').html('');
                    showModal('Error',resp.msg);
                }
                $('#startBtn').prop('disabled','');
            }).error(function(jqXHR, textStatus, errorThrown){
                showModal(textStatus,errorThrown);
                $('#startBtn').removeClass('btn-danger');
                $('#startBtn').addClass('btn-primary');
                $('#testcase_current').html('');
                $('#testcase_total').html('');
                $('#cases,#startBtn').prop('disabled','');
            })
        });
    }

    var initStartOperation = function() {
        $('#startOperationBtn').click(function(e) {
            $('#size, #operations, #startOperationBtn').prop('disabled','disabled');
            $.ajax({
                type: "POST",
                url: options.URL_SENDTESTPARAMS,
                dataType: 'json',
                data: {size: $('#size').prop('value'), operations: $('#operations').prop('value')}
            }).done(function(resp) {
                if(resp.success){
                    $('#startOperationBtn').removeClass('btn-primary');
                    $('#startOperationBtn').addClass('btn-danger');
                    $('#operation_area').css('display','block');
                    $('#operation_area_current').html(resp.current);
                    $('#operation_area_total').html(resp.total);
                }
                else{
                    $('#startOperationBtn').removeClass('btn-danger');
                    $('#startOperationBtn').addClass('btn-primary');
                    $('#operation_area').css('display','none');
                    $('#size, #operations, #startOperationBtn').prop('disabled','');
                    $('#operation_area_current').html('');
                    $('#operation_area_total').html('');
                    showModal('Error',resp.msg);
                }
            }).error(function(jqXHR, textStatus, errorThrown){
                showModal(textStatus,errorThrown);
                $('#startOperationBtn').removeClass('btn-danger');
                $('#startOperationBtn').addClass('btn-primary');
                $('#operation_area_current,#operation_area_total').html('');
                $('#size, #operations, #startOperationBtn').prop('disabled','');
            })
        });
    }

    var initRadios = function() {
        $('input[name=operation]').change(function(e) {
            if(e.target.value=='U'){
                $('#update_area').css('display','block');
                $('#query_area').css('display','none');
                $('#update_content').prop('value','');
            }
            else if(e.target.value=='Q'){
                $('#query_area').css('display','block');
                $('#update_area').css('display','none');
                $('#query_content_a,#query_content_b').prop('value','');
            }

        });
    }

    var initActions = function() {
        $('#updateBtn,#queryBtn').click(function(e) {
            $('#update_content, #updateBtn, #query_content_a, #query_content_b, #queryBtn').prop('disabled','disabled');
            $.ajax({
                type: "POST",
                url: options.URL_SENDOPERATION,
                dataType: 'json',
                data: getObjectOperation(e)
            }).done(function(resp) {
                if(resp.success){
                    $('#body_result').append('<tr><td>'+resp.log.testCase+'</td><td>'+resp.log.operation+'</td><td>'+resp.log.result+'</td></tr>');
                    if(resp.next > resp.total){
                        $('#operation_area_current,#operation_area_total').html('');
                        $('#update_area,#query_area,#operation_area').css('display','none');
                        $('#startOperationBtn').removeClass('btn-danger');
                        $('#startOperationBtn').addClass('btn-primary');
                        $('#size, #operations, #startOperationBtn').prop('disabled','');

                        if(resp.nextCase > resp.totalCase){
                            $('#testcase').css('display','none');
                            showModal('Exito','Los casos de prueba han finalizado con éxito!!!');
                        }
                        else $('#testcase_current').html(resp.nextCase);
                    }
                    else{
                        $('#operation_area_current').html(resp.next);
                        $('#operation_area_total').html(resp.total);
                    }
                }
                else{
                    showModal('Error',resp.msg);
                }
                $('#update_content, #query_content_a, #query_content_b').prop('value','');
                $('#update_content, #updateBtn, #query_content_a, #query_content_b, #queryBtn').prop('disabled','');
            }).error(function(jqXHR, textStatus, errorThrown){
                showModal(textStatus,errorThrown);
                $('#update_content, #updateBtn, #query_content_a, #query_content_b, #queryBtn').prop('disabled','');
            })
        });
    }


    var showModal = function(textStatus, errorThrown){
        $('#modal_msg .modal-title').html(textStatus);
        $('#modal_msg .modal-body').html(errorThrown);
        $('#modal_msg').modal('show');
    }

    var getObjectOperation = function(e){
        var obj = {operation: e.target.id};
        if(e.target.id == 'queryBtn'){
            obj.querya = $('#query_content_a').prop('value');
            obj.queryb = $('#query_content_b').prop('value');
        }
        else if(e.target.id == 'updateBtn')
            obj.update = $('#update_content').prop('value');
        return obj;
    }

    return {
        init: function(opts) {
            var defaults = {};
            options = $.extend({}, defaults, opts);
            $('input').popover();

            regenerate();
            initStartButton();
            initStartOperation();
            initRadios();
            initActions();
        }
    }
}();

