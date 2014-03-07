<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('edit_language', null, 'localizationMessages') ?>
        </div>
        <form action="<?php echo url_for('edit_language'); ?>" method="post" id="add_language_form" name="add_language_form">
            <?php echo $form->renderHiddenFields(); ?>
            <table class="mainFrame mediumText">
                <?php
                $globalErrors = $form->getGlobalErrors();
                if (count($globalErrors) > 0) {
                    foreach ($globalErrors as $name => $error) {
                        ?>
                        <tr>
                            <td colspan="4" class="errorMsg"><?php echo $error ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td  class="labelColumn"><?php echo $form['name']->renderLabel(__('language_name', null, 'localizationMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth addDotLinetoRight"><?php echo $form['name']->render() ?>
                        <div class="errorMsg">
                            <?php if ($form['name']->hasError()) { ?>
                                <?php echo $form['name']->renderError() ?>
                            <?php } ?>
                        </div>
                </tr>  
                <tr>
                    <td  class="labelColumn"><?php echo $form['code']->renderLabel(__('language_code', null, 'localizationMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth addDotLinetoRight"><?php echo $form['code']->render() ?>
                        <div class="errorMsg">
                            <?php if ($form['code']->hasError()) { ?>
                                <?php echo $form['code']->renderError() ?>
                            <?php } ?>
                        </div>
                </tr>  

            </table>
            <?php include_partial('localization/mandetoryFieldMessage') ?>
            <input type="button" name="udate_language" id="update_language" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>" />
            <input type="button" name="cancel_bttn" id="cancel_bttn" class="button normalText" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
        </form>
    </div>
</div>

<script type="text/javascript">
    $(".sf-menu li.language").addClass("current");
    var resetUrl = '<?php echo url_for("@language_list") ?>';
    var langId = '<?php echo $langId ?>';
    var langEdit = '<?php echo __('edit', null, 'localizationMessages') ?>';
    var langSave = '<?php echo __('save', null, 'localizationMessages') ?>';
</script>



