<script type="text/javascript">
    $(".sf-menu li.manageLabels").addClass("current");
</script>
<div id="labelUploadDiv" class="outerBorder homePageBorder" style="width: 600px; display: block;">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('manage_labels', null, 'localizationMessages') ?>
        </div>
        <div >
            
        <form action="<?php echo url_for('@manage_labels'); ?>" method="post" id="upload_label_form" name="upload_label_form" enctype="multipart/form-data">
            <?php echo $addLabelUploadForm->renderHiddenFields(); ?>
            <table width="100%" class="mediumText mainFrame">
                <tr><td><?php echo $addLabelUploadForm['Language_group']->renderLabel(); ?><span class="mandatoryStar">*</span></td>
                    <td><?php echo $addLabelUploadForm['Language_group']->render(); ?></td></tr>
                
                <tr><td><?php echo $addLabelUploadForm['Source_note']->renderLabel(); ?></td>
                    <td><?php echo $addLabelUploadForm['Source_note']->render(); ?></td></tr>
                
                <tr><td><?php echo $addLabelUploadForm['Include_target_value']->renderLabel(); ?></td>
                    <td><?php echo $addLabelUploadForm['Include_target_value']->render(); ?></td></tr>
                <tr><td><?php echo $addLabelUploadForm['Target_language']->renderLabel(); ?><span class="mandatoryStar">*</span></td>
                    <td><?php echo $addLabelUploadForm['Target_language']->render(); ?></td></tr>
                <tr><td><?php echo $addLabelUploadForm['Target_note']->renderLabel(); ?></td>
                    <td><?php echo $addLabelUploadForm['Target_note']->render(); ?></td></tr>
                <tr><td><?php echo $addLabelUploadForm['File']->renderLabel(); ?></td>
                    <td><?php echo $addLabelUploadForm['File']->render(); ?><div id="xmlHelpMessage"><span class="mandatoryStar">*</span>Support only valid XML files.</font></div></td></tr>
            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?>
            <input type="button" name="upload_and_save_xml" id="upload_and_save_xml" class="button normalText" value="<?php echo __('Upload', null, 'localizationMessages') ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="upload_and_cancel_xml" id="upload_and_cancel_xml" class="button normalText" value="<?php echo __('Cancel', null, 'localizationMessages') ?>" style="display: none;"/>
        </form>
    </div>
</div>
</div>


<div id="addLabelDiv2" style="display: none;">
<div class="outerBorder homePageBorder addLabelPage">
    <div class="homePage">
    <form action="<?php echo url_for('@add_label'); ?>" method="post" id="add_label_form" name="add_label_form">
    <?php echo $addLabelForm->renderHiddenFields(); ?>
        <table class="mediumText mainFrame">
                <tr><td><?php echo $addLabelForm['Label']->renderLabel(); ?><span class="mandatoryStar">*</span></td>
                    <td><?php echo $addLabelForm['Label']->render(); ?></td></tr>
                <tr><td><?php echo $addLabelForm['Language_group']->renderLabel(); ?><span class="mandatoryStar">*</span></td>
                    <td><?php echo $addLabelForm['Language_group']->render(); ?></td></tr>
                <tr><td><?php echo $addLabelForm['Label_note']->renderLabel(); ?></td>
                    <td><?php echo $addLabelForm['Label_note']->render(); ?></td></tr>
              
            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?>
        <input type="button" name="addSourceButton" id="addSourceButton" class="button normalText" value="<?php echo __('Add', null, 'localizationMessages') ?>" />
        <input type="button" name="addSourceCancelButton" id="addSourceCancelButton" class="button normalText" value="<?php echo __('cancel', null, 'localizationMessages') ?>" />
    </form>
</div>
</div>
</div>    



<br/>
<div>
    <table width="100%"><tr><td>
    <input type="button" name="edit" id="editAdminLabel" class="button normalText" value="<?php echo __('edit', null, 'localizationMessages') ?>" />&nbsp;
    <input type="button" name="delete" id="deleteAdminLabel" class="button normalText" value="<?php echo __('delete', null, 'localizationMessages') ?>" /> &nbsp;
    <input type="button" name="addAdminLabel" id="addAdminLabel" class="button normalText" value="<?php echo __('add', null, 'localizationMessages') ?>" />
            </td></tr></table>
</div>
<br/>



<form name="deleteLanguageLabelList" id="deleteLanguageLabelList" method="post" action="<?php echo url_for("localization/deleteLabelList") ?>">

<table class="mainFrame mediumText">
    <thead>
        <tr>
            <td width="10px" ><input type="checkbox" class="checkbox_list" name="checkall" id="checkall" onclick='checkedAll();' /></td>
            <td class="boldText" width="10px" >ID</td>
            <td width="320px" class="boldText">Label</td>
            <td class="boldText">Note</td>
            <td class="addDotLinetoRight">&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <?php if ($LabelDataArray) { array_multisort($LabelDataArray[1], SORT_ASC, SORT_STRING); ?>
        <?php $j=0; foreach ($LabelDataArray as $item) { $j++?>
    <tr>
        <td><input class="checkbox_list" type="checkbox" name="checkedid[]" value="<?php echo $item[0]; ?>" onclick="uncheckCheckAll();"/></td>
        <td class="labelNameData"><?php echo $j; ?></td>
        <td class="labelNameData"><input name="labelName[]"  style="width: 300px;" type="text" value="<?php echo $item[1]; ?>" /></td>
        <td class="labelNameData"><input name="labelNote[]"  style="width: 700px;" type="text" value="<?php echo $item[2]; ?>"  /></td>
        <td class="labelNameData"><input name="labelId[]" style="display: none;" type="text" value="<?php echo $item[0]; ?>" /></td>
        <td class="addDotLinetoRight">&nbsp;</td>
    </tr>
        <?php }
        }
        ?>
    </tbody>
</table>
</form>
    