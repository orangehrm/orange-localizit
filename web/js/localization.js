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
            $(".messageBar").html('');
            checkMessageBar();
            generateDictionary('localization/generateDictionary',targetLanguageId ,lanagueGroupId);
        } else {
            $(".messageBar").html("<span class='error'>Select Valid Target Language and Language Group</span>");
            checkMessageBar();
        }
    });

    $('#downloadDictionary').click(function (){
        $('#addLabelDiv').fadeOut(1000);
        targetLanguageId=$('#languageList').val();
        languageGroupId = $('#add_label_language_group_id').val();
        if((languageGroupId != "0") && (targetLanguageId != 0)) {
            $(".messageBar").html('');
            checkMessageBar();
            downloadDictionary('localization/downloadDictionary', targetLanguageId, languageGroupId);
        } else {
            $(".messageBar").html("<span class='error'>Select Valid Target Language and Language Group</span>");
            checkMessageBar();
        }
    });
    
    $('#deleteAdminLabel').click(function (){
        $(".messageBar span").remove();
        checkMessageBar();
        var isSelected = $(".checkbox_list").is(':checked');
        if(isSelected) {
        $(".listMessageBar span").remove();
            checkMessageBar();
            jConfirm("Are you sure you want to delete selected labels","Warning", function(r) {
                if (r) submitForm('deleteLanguageLabelList');
            });
        } else {
            $(".listMessageBar").html("<span class='error'>Please Select at Least One Row to Delete</span>");
            checkMessageBar();
        }
    });
    
    $('#upload_and_save_xml').click(function (){
        if(validateUploadForm())
            {
                submitForm('upload_label_form');
            }
    });
    $('#search').click(function(){
        $('#pageNo').val(0);
    });
    $('#upload_and_cancel_xml').click(function (){
                $('#labelSearchDiv').fadeIn(3000);
                $('#labelUploadDiv').hide();
                $('#addLabelDiv2').hide();
    });
    $('#addSourceCancelButton').click(function (){
                $('#labelSearchDiv').fadeIn(3000);
                $('#addLabelDiv2').hide();
                $('#labelUploadDiv').hide();
    });
    $('#addAdminLabel').click(function (){
                $('#labelUploadDiv').hide();
                $('#labelSearchDiv').hide();
                $('#addLabelDiv2').fadeIn(3000);
    });
    $('#uploadAdminLabel').click(function (){
                $('#addLabelDiv2').fadeOut(10);
                $('#labelSearchDiv').hide();
                $('#labelUploadDiv').fadeIn(3000);
    });
    
    
    $('.labelNameData input').attr("disabled", "disabled");
    $('.labelNameData textarea').attr("disabled", "disabled");
    $('.labelNameData select').attr("disabled", "disabled");
    //$('.checkbox_list').attr("disabled", "disabled");
    $('#editAdminLabel').click(function (){          
        var a = $(this).val();
        if(a == 'Edit')
            {
                $(this).val('Save');
                $('.labelNameData input').removeAttr("disabled");
                $('.labelNameData textarea').removeAttr("disabled");
                $('.labelNameData select').removeAttr("disabled");
            }
        if(a == 'Save')
            {
            var editSourceForm = $("#deleteLanguageLabelList .changed, #deleteLanguageLabelList input[type='hidden']").serialize();
            var saveurl = $("#deleteLanguageLabelList").attr('action');
            $.ajax(
                    {
                        type: "POST",
                        url: saveurl,
                        data: editSourceForm,
                        success:
                            function(responseData)
                            {
                                 $("#groupSearchForm").submit();
                            },
                        error:
                            function()
                            {
                            }
                    });
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
    
    $("#uploadForm_Target_language").attr("disabled", "disabled");
    $("#uploadForm_Target_note").attr("disabled", "disabled");
    $("#uploadForm_Target_language").closest("tr").find("td .mandatoryStar").hide();
    $('#uploadForm_Include_target_value').click(function(){
        if ($('#uploadForm_Include_target_value').is(':checked'))
        {
            $("#uploadForm_Target_language").removeAttr("disabled");
            $("#uploadForm_Target_note").removeAttr("disabled");
            $("#uploadForm_Target_language").closest("tr").find("td .mandatoryStar").show();
            
        }
        else
        {
            $("#uploadForm_Target_language").attr("disabled", "disabled");
            $("#uploadForm_Target_note").attr("disabled", "disabled");
            $("#uploadForm_Target_language").closest("tr").find("td .mandatoryStar").hide();
        }
       
    });
 
    if($('#show_add_label').val() == '1'){
        $('#addLabelDiv').css('display','block');
    } else {
        $('#addLabelDiv').css('display','none');
    }
    if((typeof(languageArray) !== 'undefined') && userType == 'Moderator'){
        $("#languageList option").each(function() {
            if(($.inArray(parseInt($.trim($(this).val())), languageArray) == -1) && ($(this).val() != 0)){
                $(this).remove();
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
        $(".listMessageBar span").remove();
        checkMessageBar();
        $(".target_label_input").attr("disabled", "disabled");
        $(".target_note_input").attr("disabled", "disabled");
        $("#show_label_form").find("input#save").hide();
        $("#show_label_form").find("input#cancel").hide();
        $("#show_label_form").find("input#edit").show();
    });
    
    $(".target_label_input, .target_note_input").change(function() {
        $(this).closest('tr').find(".target_note_input").addClass("changed");
        $(this).closest('tr').find(".target_label_input").addClass("changed");
    });
    
    $(".sourceValueInput, .sourceNoteInput, .sourceGroupInput").change(function() {
        $(this).closest('tr').find(".sourceValueInput").addClass("changed");
        $(this).closest('tr').find(".sourceNoteInput").addClass("changed");
        $(this).closest('tr').find(".sourceIdInput").addClass("changed");
        $(this).closest('tr').find(".sourceGroupInput").addClass("changed");
    });
    
    $("#show_label_form input#cancel").click(function() {
        $(".changed").each(function(){
            $(this).removeClass('changed');
        })
    });
    
    $("#show_label_form").find("input#save").click(function (event) {
        event.preventDefault();
        var showLableForm = $("#show_label_form .changed, #show_label_form input[type='hidden']").serialize();
        var saveurl = $("#show_label_form").attr('action');
        $.ajax(
            {
                type: "POST",
                url: saveurl,
                data: showLableForm,
                success:
                    function(responseData)
                    {
                         $('#pageNo').val($('#saveFormPageNo').val());
                         $("#language_search_form").submit();
                    },
                error:
                    function()
                    {
                    }
            });
    });
    checkMessageBar();
    
    $("#show_label_form input.target_label_input").each(function() {
        if($(this).val() == '') {
            $(this).closest('tr').addClass('emptyRows');
        } else {
            $(this).closest('tr').removeClass('emptyRows');
        }
    });
    
    if($('#langId').length > 0) {
        if($('#user_user_type_id').val() != 2) {
            $('#langId').hide();
        }
    }
    
    if($('.sourceValueInput').length > 0) {
        var stringCount = 1;
        var stringArray = new Array();
        $(".sourceValueInput").each(function() {
            var sourceValue = $.trim($(this).val());
            if($.inArray(sourceValue,stringArray) < 0) {
                stringArray[stringCount] = sourceValue;
                stringCount++;
            } else {
                $(".sourceValueInput[value='"+sourceValue+"']").closest('tr').addClass('duplicate')
            }
        });
    }
});

function checkMessageBar() {
    if($('.messageBar span').length > 0){
        $('.messageBar').show();
    } else {
        $('.messageBar').hide();
    }
    
    if($(".listMessageBar span").length > 0) {
        $('.listMessageBar').show();
    } else {
        $('.listMessageBar').hide();
    }
}
function redircetToPage(path) {
    window.location.href = path;
}

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
            location.reload();
        },
        error: function(){
            $(".messageBar").html("<span class='error'>Sorry, You Have No Access for This Language</span>");
            checkMessageBar();
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
            $.ajax(
                    {
                        type: "GET",
                        url: 'userManagement/delete',
                        data: {'user_id':id},
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
    var withTarget = $("#uploadForm_Include_target_value").is(':checked');
    $(".listMessageBar span").remove();
    checkMessageBar();
    if(lanGroup == ''){$(".messageBar").html("<span class='error'>Please Select Language Group</span>");checkMessageBar();}
    else if((tarLan == '') && withTarget){$(".messageBar").html("<span class='error'>Please Select a Lanuage to Translate</span>");checkMessageBar();}
    else if(file == ''){$(".messageBar").html("<span class='error'>Please Select a File</span>");checkMessageBar();}
    else {return true;}

    
}

function validateAddSourceForm()
{
    var label = $('#addSourceForm_Label').val();
    var lanGroup = $('#addSourceForm_Language_group').val();
    
    if(label == ''){$(".messageBar").html("<span class='error'>Please Enter a Source</span>");checkMessageBar();}
    else if(lanGroup == ''){$(".messageBar").html("<span class='error'>Please Select a Group</span>");checkMessageBar();}
    else{return true;}
}

function submitPage(pageNo) {
    $('#pageNo').val(pageNo);
    $('form.pagination_enabled').submit();
} 
