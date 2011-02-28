$(document).ready(function (){

    var targetLanguageId=$('#languageList').val();
    var url=$('#url').val();
    var url_edit=$('#edit_url').val();
    $('#addLabelDiv').css('display','none');
    fetchLangugeLabelSet(url,targetLanguageId,'dataSet');

    $('#languageList').change(function (){
        targetLanguageId=$('#languageList').val();
        fetchLangugeLabelSet(url,targetLanguageId,'dataSet');
    });

    $('#edit').click(function (){
        $('#addLabelDiv').fadeOut(1000);
        targetLanguageId=$('#languageList').val();
        fetchEditableLangugeLabelSet(url_edit,targetLanguageId,'dataSet');
    });

    $('#generateDictionary').click(function (){        
        $('#addLabelDiv').fadeOut(1000);
        targetLanguageId=$('#languageList').val();
        generateDictionary('localization/generateDictionary', targetLanguageId);
    });

    $('#downloadDictionary').click(function (){
        $('#addLabelDiv').fadeOut(1000);
        targetLanguageId=$('#languageList').val();
        downloadDictionary('localization/downloadDictionary', targetLanguageId);
    });
    $('#save').click(function (){
        $('#addLabelDiv').fadeIn(1000);
        targetLanguageId=$('#languageList').val();
        $('#target_language_selected_id').val(targetLanguageId);
        submitForm('editLanguageLabelList');
    });
    $('#save_label').click(function (){
        $('#addLabelDiv').fadeIn(1000);
        submitForm('add_label_form');
    });
    $('#add').click(function (){
        $('#addLabelDiv').fadeIn(1000);
    });
    $('#cancel_label').click(function (){
        $('#addLabelDiv').fadeOut(1000);
    });
    $('#login').click(function(){
        submitForm('sign_in_form');
    });

    if($('#show_add_label').val() == '1'){
        $('#addLabelDiv').css('display','block');
    } else {
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

function generateDictionary(url,targetLanguageId){
    $.ajax({
        url: url+'?targetLanguageId='+targetLanguageId,
        success: function() {
            jAlert('Dictionary file created successfully!', 'Success');
        },
        error: function(){
            jAlert('Sorry, Something went wrong!', 'Error');
        }
    });
}

function downloadDictionary(url,targetLanguageId){
    url = url+"?targetLanguageId="+targetLanguageId;
    document.location=url;
}

function submitForm(formId){
    $('#'+formId).submit();
    return true;
}

function getWordCount(taObj,oldHtmlId,newHtmlId,labelId){
    objVal = taObj.value.split(/\W+/);
    if(objVal.length > 5) {
        $('#'+oldHtmlId+labelId).css('display', 'none');
        $('#'+newHtmlId+labelId).css('display', 'block');
        $('#'+newHtmlId+labelId).val($('#'+oldHtmlId+labelId).val());
        $('#'+oldHtmlId+labelId).remove();
    } else {
         $('#'+newHtmlId+labelId).innerHtml('<textarea  id="targetLangText1"  class="text_input" style="display: none" cols="20" rows="2" name="target_language_string[]"></textarea>');
    }
}