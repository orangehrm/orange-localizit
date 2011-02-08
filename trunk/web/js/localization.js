$(document).ready(function (){

    var targetLanguageId=$('#languageList').val();
    var url=$('#url').val();
    var url_edit=$('#edit_url').val();
    fetchLangugeLabelSet(url,targetLanguageId,'dataSet');

    $('#languageList').change(function (){
        targetLanguageId=$('#languageList').val();
        fetchLangugeLabelSet(url,targetLanguageId,'dataSet');
    });

    $('#edit').click(function (){
        targetLanguageId=$('#languageList').val();
        fetchEditableLangugeLabelSet(url_edit,targetLanguageId,'dataSet');
    });
    $('#save').click(function (){
        targetLanguageId=$('#languageList').val();
        $('#target_language_selected_id').val(targetLanguageId);
        submitForm('editLanguageLabelList');
    });
    $('#save_label').click(function (){
        submitForm('add_label_form');
    });
    $('#add').click(function (){
        $('#addLabelDiv').fadeIn(1000);
    });
    $('#cancel_label').click(function (){
        $('#addLabelDiv').fadeOut(1000);
    });

    if(!$('#show_add_label').val()){
        $('#addLabelDiv').css('display','none');
        $('#addLabelDiv').css('display','none');
    }
});


function fetchLangugeLabelSet(url,targetLanguageId,dataSetPane){
    $.ajax({
        url: url+'?targetLanguageId='+targetLanguageId,
        success: function(data) {
            $('#'+dataSetPane).html('');
            $('#'+dataSetPane).html(data);
        },
        error: function(e){
        }
    });
}
function fetchEditableLangugeLabelSet(url,targetLanguageId,dataSetPane){
    $.ajax({
        url: url+'?targetLanguageId='+targetLanguageId,
        success: function(data) {
            $('#'+dataSetPane).html('');
            $('#'+dataSetPane).html(data);
            $('#edit').css('display','none');
            $('#save').css('display','');
        },
        error: function(e){
        }
    });
}

function submitForm(formId){
    $('#'+formId).submit();
    return true;
}