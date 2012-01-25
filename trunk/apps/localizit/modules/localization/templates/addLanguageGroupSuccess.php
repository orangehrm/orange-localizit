<script type="text/javascript">
    $(".sf-menu li.group").addClass("current");
</script>
<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('new_group', null, 'localizationMessages') ?>
        </div>
        <form action="<?php echo url_for('@add_language_group'); ?>" method="post" id="add_language_group_form" name="add_language_group_form">
            <?php echo $addLanguageGroupForm->renderHiddenFields(); ?>
            <table class="mainFrame mediumText">
                <?php
                $globalErrors = $addLanguageGroupForm->getGlobalErrors();
                if (count($globalErrors) > 0) {
                    foreach ($globalErrors as $name => $error) {
                ?>
                        <tr>
                            <td colspan="4" class="errorMsg"><?php echo $error ?></td>
                        </tr>
                <?php }
                } ?>
                <tr>
                    <td  class="labelColumn"><?php echo $addLanguageGroupForm['group_name']->renderLabel(__('group_name', null, 'localizationMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $addLanguageGroupForm['group_name']->render() ?></td>
                    <!--<td class="tableColumnWidth removeLeftDotLine errorMsg addDotLinetoRight">
                    <?php if ($addLanguageGroupForm['group_name']->hasError()) { ?>
                    <?php echo $addLanguageGroupForm['group_name']->renderError() ?>
                    <?php } ?>
                    </td>
                --></tr>                     
               
            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?>
            <input type="button" name="save_group" id="save_group" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>" />
            <input type="button" name="cancel_user" id="cancel_user" class="button normalText" onclick="redircetToPage('<?php echo url_for("@language_group_list")?>')" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
            
        </form>
    </div>
</div>
