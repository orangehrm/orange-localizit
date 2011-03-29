<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('edit_user', null, 'userManagementMessages') ?>
        </div>
        <form action="<?php echo url_for('@edit_user'); ?>" method="post" id="edit_user_form" name="edit_user_form">
            <?php echo $editUserForm->renderHiddenFields(); ?>
            <table class="mainFrame mediumText">
                <?php
                $globalErrors = $editUserForm->getGlobalErrors();
                if (count($globalErrors) > 0) {
                    foreach ($globalErrors as $name => $error) {
                ?>
                        <tr>
                            <td colspan="4" class="errorMsg"><?php echo $error ?></td>
                        </tr>
                <?php }
                } ?>
                <tr>
                    <td class="tableIndexColumn">&nbsp;</td>
                    <td  class="tableColumnWidth removeLeftDotLine"><?php echo $editUserForm['login_name']->renderLabel(__('username', null, 'authenticationMessages')) ?> *</td>
                    <td class="tableColumnWidth"><?php echo $editUserForm['login_name']->render() ?></td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight errorMsg">
                    <?php if ($editUserForm['login_name']->hasError()) { ?>
                    <?php echo $editUserForm['login_name']->renderError() ?>
                    <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td class="tableIndexColumn">&nbsp;</td>
                    <td  class="tableColumnWidth removeLeftDotLine"><?php echo $editUserForm['password']->renderLabel(__('password', null, 'authenticationMessages')) ?> *</td>
                    <td class="tableColumnWidth"><?php echo $editUserForm['password']->render() ?></td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight errorMsg">
                    <?php if ($editUserForm['password']->hasError()) { ?>
                    <?php echo $editUserForm['password']->renderError() ?>
                    <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td class="tableIndexColumn">&nbsp;</td>
                    <td class="tableColumnWidth removeLeftDotLine">
                       <?php echo $editUserForm['user_type_id']->renderLabel(__('user_type', null, 'authenticationMessages')) ?> *
                    </td>
                    <td><?php include_component('userManagement', 'UserList'); ?>
                    </td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight">
                    &nbsp;
                    </td>
                </tr>

               <tr id="langId">
                    <td class="tableIndexColumn">&nbsp;</td>
                    <td class="tableColumnWidth removeLeftDotLine">
                        <?php echo __('languages', null, 'userManagementMessages') ?>
                    </td>
                    <td>
                            <?php if( count($langList) > 0) { ?>
                        <table style="width: 250px; background: none; border-collapse: none; border-top: none ; border-bottom: none ">
                                <tr>
                                <?php foreach ($langList as $language) { ?>
                                    <td style="border-top: none; border-left: none;">
                                        <input type="checkbox" name="add_user[user_languages][]" value="<?php echo $language->getLanguageId() ?>" />
                                                <?php echo $language->getLanguageCode()?>
                                    </td>
                                <?php } ?>
                                </tr>
                            </table>
                            <?php } ?>
                    </td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight">&nbsp;</td>
                </tr>

                 <tr>
                    <td>&nbsp;</td>
                    <td  class="removeLeftDotLine">&nbsp;</td>
                    <td>
                        <input type="button" name="save_user" id="save_user" class="button normalText" value="<?php echo __('update', null, 'localizationMessages') ?>" />
                        <input type="button" name="cancel_user" id="cancel_user" class="button normalText" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
                    </td>
                    <td class="removeLeftDotLine addDotLinetoRight">&nbsp;</td>
                </tr>

            </table>
        </form>
    </div>
</div>
