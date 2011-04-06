$(document).ready(function (){

    var targetLanguageId=$('#languageList').val();
    var url=$('#url').val();
    var url_edit=$('#edit_url').val();
    var url_allow_edit = $('#allow_edit_url').val();

    $('#addLabelDiv').css('display','none');
    fetchLangugeLabelSet(url,targetLanguageId,'dataSet');
    displayEditButton(url_allow_edit, targetLanguageId);

    $('#languageList').change(function (){
        $('#edit').css('display','');
        $('#generateDictionary').css('display','');
        $('#save').css('display','none');
        targetLanguageId=$('#languageList').val();
        fetchLangugeLabelSet(url,targetLanguageId,'dataSet');
        displayEditButton(url_allow_edit, targetLanguageId);
    });

    $('#edit').click(function (){
        $('#addLabelDiv').fadeOut(1000);
        $('#add').css('display','none');
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
    $('#save_user').click(function(){
        submitForm('add_user_form');
    });
    $('#update_user').click(function(){
        submitForm('edit_user_form');
    });
    $('#save_group').click(function(){
        submitForm('add_language_group_form');
    });
    $('#update_group').click(function(){
        submitForm('edit_language_group_form');
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

function displayEditButton(url, targetLanguageId) {
    $.ajax({
        url: url+'?targetLanguageId='+targetLanguageId,
        success: function(data) {
            $('#edit').css('display','none');
            $('#generateDictionary').css('display','none');
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
            jAlert('Sorry, You have no access for this language!', 'Error');
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

function  displayLanguageList(val){
    if(val == 2 ) {
        $('#langId').fadeIn(1000);
        $('#displayLangId').fadeIn(1000);
    } else {
        $('#langId').fadeOut(1000);
        $('#displayLangId').fadeOut(1000);
    }
}

function  deleteUser(id){

    jConfirm('Are you sure?', 'Delete User', function(r) {
        if(r) {
            $.get('userManagement/delete?user_id='+id);
            location.reload();
        }
    });
}

function deleteLangGroup(id) {
    jConfirm('Are you sure?', 'Delete User', function(r) {
        if(r) {
            $.get('localization/deleteLanguageGroup?id='+id);
            location.reload();
        }
    });
}