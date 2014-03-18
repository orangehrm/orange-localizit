var langId = 0;
var langEdit = null;
var langSave = null;
var resetUrl = null;

$(document).ready(function() {

    $('.messageBar.manageLabels').delay(2000).fadeOut("slow", function() {
        $(".messageBar.manageLabels").hide();
    });

    $('#save_language').click(function() {
        if ($('#add_language_form').valid()) {
            $('#add_language_form').submit();
        }
    });

    $('#update_language').click(function() {
        if ($('#update_language').val() == langEdit) {
            $('#language_name').removeAttr('disabled');
            $('#language_code').removeAttr('disabled');
            $('#update_language').val(langSave);
        }
        else if ($('#update_language').val() == langSave) {
            if ($('#add_language_form').valid()) {
                $('#add_language_form').submit();
            }
        }
    });

    $('#cancel_bttn').click(function() {
        window.location.replace(resetUrl);
    });

    if (langId > 0) {
        $('#language_name').attr('disabled', 'disabled');
        $('#language_code').attr('disabled', 'disabled');
        $('#update_language').val(langEdit);
    }

    var validator = $('#add_language_form').validate({
        rules: {
            'language[name]': {
                required: true,
                maxlength: 255
            }, 'language[code]': {
                required: true,
                maxlength: 255
            }
        }, messages: {
            'language[name]': {
                required: 'Required',
                maxlength: 'Exceed the Allowed length'
            }, 'language[code]': {
                required: 'Required',
                maxlength: 'Exceed the Allowed length'
            }
        }

    });

});

function deleteLanguage(id) {
    jConfirm('Are you sure?', 'Delete Language', function(r) {
        if (r) {
            $.ajax(
                    {
                        type: "Get",
                        url: 'localization/deleteLanguage',
                        data: {'language_id': id},
                        success:
                                function(responseData)
                                {
                                    location.reload();
                                },
                        error:
                                function()
                                {
                                }
                    });
        }
    });
}


