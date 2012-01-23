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
        lanagueGroupId = $('#add_label_language_group_id').val();
        if ((lanagueGroupId != "0") && (targetLanguageId != 0)) {
            generateDictionary('localization/generateDictionary',targetLanguageId ,lanagueGroupId);
        } else {
            jAlert('Select valid group and language!', 'Error');
        }
    });

    $('#downloadDictionary').click(function (){
        $('#addLabelDiv').fadeOut(1000);
        targetLanguageId=$('#languageList').val();
        languageGroupId = $('#add_label_language_group_id').val();
        if((languageGroupId != "0") && (targetLanguageId != 0)) {
            downloadDictionary('localization/downloadDictionary', targetLanguageId, languageGroupId);
        } else {
            jAlert('Select valid group and language!', 'Error');
        }
    });
    
    $('#deleteAdminLabel').click(function (){
        var r=confirm("Are you sure you want to delete selected labels");
        if (r==true)
        {
            submitForm('deleteLanguageLabelList');
        }
    });
    
    $('#upload_and_save_xml').click(function (){
        if(validateUploadForm())
            {
                submitForm('upload_label_form');
            }
    }); 
    $('#addAdminLabel').click(function (){
        var a = $(this).val();
        if(a == 'Add')
            {
                $(this).val('Upload');
                $('#labelUploadDiv').fadeOut(10);
                $('#addLabelDiv2').fadeIn(3000);
            }
        if(a == 'Upload')
            {
                $(this).val('Add');
                $('#addLabelDiv2').fadeOut(10);
                $('#labelUploadDiv').fadeIn(3000);
            }
    });
    $('#addSourceCancelButton').click(function (){
       $('#labelUploadDiv').fadeIn(3000);
       $('#addLabelDiv2').fadeOut(10); 
    });
    
    $('.labelNameData input').attr("disabled", "disabled");
    //$('.checkbox_list').attr("disabled", "disabled");
    $('#editAdminLabel').click(function (){          
        var a = $(this).val();
        if(a == 'Edit')
            {
                $(this).val('Save');
                $('.labelNameData input').removeAttr("disabled");
                //$('.checkbox_list').removeAttr("disabled");

            }
        if(a == 'Save')
            {
                submitForm('deleteLanguageLabelList');
                $(this).val('Edit');
                $('.labelNameData input').attr("disabled", "disabled");
                //$('.checkbox_list').attr("disabled", "disabled");
            }
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
    $('#addSourceButton').click(function (){
        if(validateAddSourceForm())
            {
                submitForm('add_label_form');
            }
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
    if((typeof(languageArray) !== 'undefined') && userType == 'Moderator'){
        $("#languageList option").each(function() {
            if($.inArray(parseInt($.trim($(this).val())), languageArray) == -1){
                $(this).hide();
            }
        });
    }
    if(typeof(setLanguageId) !== 'undefined') {
        $("#languageList").val(setLanguageId);
        $("#add_label_language_group_id").val(languageGroupId);
    }
    
    $("#show_label_form").find("input#save").hide();
    $("#show_label_form").find("input#cancel").hide();
    $(".target_label_input").attr("disabled", "disabled");
    $(".target_note_input").attr("disabled", "disabled");

    $("#show_label_form").find("input#edit").click(function () {
        $("#show_label_form").find("input#save").show();
        $("#show_label_form").find("input#cancel").show();
        $(".target_label_input").removeAttr("disabled");
        $(".target_note_input").removeAttr("disabled");
        $(this).hide();
    });
    $("#show_label_form").find("input#cancel").click(function () {
        $(".target_label_input").attr("disabled", "disabled");
        $(".target_note_input").attr("disabled", "disabled");
        $("#show_label_form").find("input#save").hide();
        $("#show_label_form").find("input#cancel").hide();
        $("#show_label_form").find("input#edit").show();
    });
    $("#show_label_form").find("input#save").click(function () {
        event.preventDefault();
        var showLableForm = $("#show_label_form").serialize();
        var saveurl = $("#show_label_form").attr('action');
        $.ajax(
            {
                type: "POST",
                url: saveurl,
                data: showLableForm,
                success:
                    function(responseData)
                    {
                         $("#language_search_form").submit();
                    },
                error:
                    function()
                    {
                    }
            });
    });
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

function generateDictionary(url,targetLanguageId,languageGroupId){
    $.ajax({
        url: url+'?targetLanguageId='+targetLanguageId +'&languageGroupId='+languageGroupId,
        success: function() {
            jAlert('Dictionary file created successfully!', 'Success');
        },
        error: function(){
            jAlert('Sorry, You have no access for this language!', 'Error');
        }
    });
}

function downloadDictionary(url,targetLanguageId, languageGroupId){
    url = url+"?targetLanguageId="+targetLanguageId+"&languageGroupId="+languageGroupId;
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

checked = false;
function checkedAll()
{
    if (checked == false){checked = true}else{checked = false}
    for (var i = 0; i < document.getElementById('deleteLanguageLabelList').elements.length; i++) {
      document.getElementById('deleteLanguageLabelList').elements[i].checked = checked;
    }  
}

function uncheckCheckAll()
{
    document.getElementById('deleteLanguageLabelList').elements[0].checked = false;
}

function validateUploadForm()
{
    var lanGroup = $('#uploadForm_Language_group').val();
    var tarLan = $('#uploadForm_Target_language').val();
    var file = $('#uploadForm_File').val();
    
    if(lanGroup == ''){alert ("Please select language Group");}
    else if(tarLan == ''){alert ("Please select a lanuage to translate");}
    else if(file == ''){alert ("Please select a file");}
    else {return true;}

    
}

function validateAddSourceForm()
{
    var label = $('#addSourceForm_Label').val();
    var lanGroup = $('#addSourceForm_Language_group').val();
    
    if(label == ''){alert("Please enter a label");}
    else if(lanGroup == ''){alert("Please select a language group");}
    else{return true;}
}