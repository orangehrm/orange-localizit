<div class="outerBorder homePageBorder">
    <div class="homePage">
        <span class="errorMsg"><?php echo $sf_user->getFlash('message'); ?></span>
        <table class="mainFrame mediumText">
            <tr class="mainRowWidth">
                <td class="tableColumnWidth"><?php echo __('source_language', null, 'localizationMessages') ?></td>
                <td class="tableColumnWidth addDotLinetoRight"><?php echo $sourceLanguageLabel; ?></td>
            </tr>
            <tr>
                <td class=""><?php echo __('target_language', null, 'localizationMessages') ?></td>
                <td class="addDotLinetoRight"><?php include_component('localization', 'LanguageList'); ?></td>
            </tr>
            <table class="mainFrame">
                <tr>
                <td><?php $role = sfContext::getInstance()->getUser()->getUserRole(); ?>
                    <?php if ($role->isAllowedToAddLabel()) { ?>
                        <input type="button" name="add" id="add" class="button normalText" value="<?php echo __('add', null, 'localizationMessages') ?>" />&nbsp;
                    <?php } ?>
                    <input type="button" name="edit" id="edit" class="button normalText" value="<?php echo __('edit', null, 'localizationMessages') ?>" />&nbsp;
                    <input type="button" name="save" id="save" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>" style="display: none;"/>
                    <?php if (count($role->getAllowedLanguageList()) != 0) { ?>
                        <input type="button" name="generateDictionary" id="generateDictionary" class="button normalText" value="<?php echo __('generate_dictionary', null, 'localizationMessages') ?>" />&nbsp;
                    <?php } ?>
                    <?php if ($role->isAllowedToDownloadDirectory()) { ?>
                        <input type="button" name="downloadDictionary" id="downloadDictionary" class="button normalText" value="<?php echo __('download_dictionary', null, 'localizationMessages') ?>" />
                    <?php } ?>
                </td>
            </tr>
            </table>
        </table>
    </div>
</div>

<div id="addLabelDiv">
<div class="outerBorder homePageBorder addLabelPage">
    <div class="homePage">
    <form action="<?php echo url_for('@add_label'); ?>" method="post" id="add_label_form" name="add_label_form">
        <?php echo $addLabelForm->renderHiddenFields(); ?>
        <div class="mediumText pageHeader">
            <?php echo __('add_label', null, 'localizationMessages')?>
        </div>
        <table class="mainFrame mediumText">
          
            <?php
            $globalErrors = $addLabelForm->getGlobalErrors();
            if (count($globalErrors) > 0) {
                foreach ($globalErrors as $name => $error) {
            ?>
                    <tr>
                        <td colspan="4"><?php echo $error ?></td>
                    </tr>
            <?php }
            } ?>
            <tr>
                <td class="tableIndexColumn">&nbsp;</td>
                <td  class="tableColumnWidth removeLeftDotLine"><?php echo $addLabelForm['label_name']->renderLabel(__('label', null, 'localizationMessages')) ?> *</td>
                <td class="tableColumnWidth"><?php echo $addLabelForm['label_name']->render() ?></td>
                <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight">&nbsp;</td>
            </tr>
            <?php if ($addLabelForm['label_name']->hasError()) {
 ?>
                <tr>
                    <td>&nbsp;</td>
                    <td  class="removeLeftDotLine">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2" class="removeLeftDotLine addDotLinetoRight"><?php echo $addLabelForm['label_name']->renderError() ?></td>
                </tr>
<?php } ?>
            <tr>
                <td>&nbsp;</td>
                <td  class="removeLeftDotLine"><?php echo $addLabelForm['label_local_language_string']->renderLabel($sf_user->getCulture()) ?> *</td>
                <td><?php echo $addLabelForm['label_local_language_string']->render() ?></td>
                <td class="removeLeftDotLine addDotLinetoRight">&nbsp;</td>
            </tr>

<?php if ($addLabelForm['label_local_language_string']->hasError()) { ?>
                <tr>
                    <td>&nbsp;</td>
                    <td  class="removeLeftDotLine">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2" class="removeLeftDotLine addDotLinetoRight"><?php echo $addLabelForm['label_local_language_string']->renderError() ?></td>
                </tr>
<?php } ?>
            <tr>
                <td>&nbsp;</td>
                <td  class="removeLeftDotLine"><?php echo $addLabelForm['label_comment']->renderLabel(__('label_comment', null, 'localizationMessages')) ?></td>
                <td><?php echo $addLabelForm['label_comment']->render() ?></td>
                <td class="removeLeftDotLine addDotLinetoRight">&nbsp;</td>
            </tr>

<?php if ($addLabelForm['label_comment']->hasError()) { ?>
                <tr>
                    <td>&nbsp;</td>
                    <td  class="removeLeftDotLine">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2" class="removeLeftDotLine addDotLinetoRight"><?php echo $addLabelForm['label_comment']->renderError() ?></td>
                </tr>
<?php } ?>

            <tr>
                <td>&nbsp;</td>
                <td  class="removeLeftDotLine">&nbsp;</td>
                <td>
                    <input type="button" name="save_label" id="save_label" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>" />
                    <input type="button" name="cancel_label" id="cancel_label" class="button normalText" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
                </td>
                <td class="removeLeftDotLine addDotLinetoRight">&nbsp;</td>
            </tr>

        </table>
    </form>
</div>
</div>
</div>
<div class="space"></div>
<div id="dataSet" >
</div>
<input type="hidden" id="url" value="<?php echo url_for('@language_label_data_set'); ?>" />
<input type="hidden" id="edit_url" value="<?php echo url_for('@language_label_data_set_edit'); ?>" />
<input type="hidden" id="show_add_label" value="<?php echo $showAddLabel; ?>" />