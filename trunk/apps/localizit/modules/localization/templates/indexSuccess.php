<?php ?>
<table class="mainFrame mediumText">
    <tr>
        <td><?php echo __('source_language', null, 'localizationMessages') ?></td>
        <td><?php echo $sourceLanguageLabel; ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><?php echo __('target_language', null, 'localizationMessages') ?></td>
        <td><?php include_component('localization', 'LanguageList'); ?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><input type="button" name="add" id="add" value="<?php echo __('add', null, 'localizationMessages') ?>" />
            <input type="button" name="edit" id="edit" value="<?php echo __('edit', null, 'localizationMessages') ?>" />
            <input type="button" name="save" id="save" value="<?php echo __('save', null, 'localizationMessages') ?>" style="display: none;"/>
            <input type="button" name="generateDictionary" id="generateDictionary" value="<?php echo __('generate_dictionary', null, 'localizationMessages') ?>" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<div id="addLabelDiv" >
    <form action="<?php echo url_for('@add_lable'); ?>" method="post" id="add_label_form" name="add_label_form">
        <?php echo $addLabelForm->renderHiddenFields(); ?>
        <table class="mainFrame mediumText">
            <?php
            $globalErrors = $addLabelForm->getGlobalErrors();
            if (count($globalErrors) > 0) {
                foreach ($globalErrors as $name => $error) {
            ?>
                    <tr>
                        <td><?php echo $error ?></td>
                    </tr>
<?php }
            } ?>
            <tr>
                <td>
<?php echo $addLabelForm['label_name']->renderLabel( __('label', null , 'localizationMessages')) ?>
                </td>
                <td>
<?php echo $addLabelForm['label_name']->render() ?>
                </td>
            </tr>
<?php if ($addLabelForm['label_name']->hasError()) { ?>
                <tr>
                    <td colspan="2">
<?php echo $addLabelForm['label_name']->renderError() ?>
                </td>
            </tr>
<?php } ?>
            <tr>
                <td>
<?php echo $addLabelForm['label_local_language_string']->renderLabel($sf_user->getCulture()) ?>
                </td>
                <td>
<?php echo $addLabelForm['label_local_language_string']->render() ?>
                </td>
            </tr>

<?php if ($addLabelForm['label_local_language_string']->hasError()) { ?>
                <tr>
                    <td colspan="2">
<?php echo $addLabelForm['label_local_language_string']->renderError() ?>
                </td>
            </tr>
<?php } ?>
            <tr>
                <td>
<?php echo $addLabelForm['label_comment']->renderLabel( __('label_comment', null , 'localizationMessages')) ?>
                </td>
                <td>
<?php echo $addLabelForm['label_comment']->render() ?>
                </td>
            </tr>
<?php if ($addLabelForm['label_comment']->hasError()) { ?>
                <tr>
                    <td colspan="2">
<?php echo $addLabelForm['label_comment']->renderError() ?>
                </td>
            </tr>
<?php } ?>
            <tr>
                <td>
                    <input type="button" name="save_label" id="save_label" value="<?php echo __('save', null, 'localizationMessages') ?>" />
                </td>
                <td>
                    <input type="button" name="cancel_label" id="cancel_label" value="<?php echo __('cancel', null , 'authenticationMessages') ?>" />
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="space"></div>
<div id="dataSet" >
</div>
<input type="hidden" id="url" value="<?php echo url_for('@language_label_data_set'); ?>" />
<input type="hidden" id="edit_url" value="<?php echo url_for('@language_label_data_set_edit'); ?>" />
<input type="hidden" id="show_add_label" value="<?php echo $showAddLabel; ?>" />