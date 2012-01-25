<script type="text/javascript">
    $(".sf-menu li.group").addClass("current");
</script>
<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('edit_group', null, 'localizationMessages') ?>
        </div>
        <form action="<?php echo url_for('@edit_language_group?id='.$id); ?>" method="post" id="edit_language_group_form" name="edit_language_group_form">
            <?php echo $editLangGroupForm->renderHiddenFields(); ?>
            <table class="mainFrame mediumText">
                <?php
                $globalErrors = $editLangGroupForm->getGlobalErrors();
                if (count($globalErrors) > 0) {
                    foreach ($globalErrors as $name => $error) {
                ?>
                        <tr>
                            <td colspan="4" class="errorMsg"><?php echo $error ?></td>
                        </tr>
                <?php }
                } ?>
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine"><?php echo $editLangGroupForm['group_name']->renderLabel(__('group_name', null, 'localizationMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth">
                        <input type="text" name="add_language_group[group_name]" id="add_language_group_group_name" value="<?php echo isset($langGroup['group_name']) ? $langGroup['group_name'] : null ?>" />
                    </td><!--
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight errorMsg">
                    <?php if ($editLangGroupForm['group_name']->hasError()) { ?>
                    <?php echo $editLangGroupForm['group_name']->renderError() ?>
                    <?php } ?>
                    </td>
                --></tr>
            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?>
            <input type="button" name="update_group" id="update_group" class="button normalText" value="<?php echo __('update', null, 'localizationMessages') ?>" />
            <input type="button" name="cancel_user" id="cancel_user" class="button normalText" onclick="redircetToPage('<?php echo url_for("@language_group_list")?>')" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
            
        </form>
    </div>
</div>
