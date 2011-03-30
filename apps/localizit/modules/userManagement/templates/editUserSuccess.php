<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('edit_user', null, 'userManagementMessages') ?>
        </div>
        <form action="<?php echo url_for('@edit_user?id='.$id); ?>" method="post" id="edit_user_form" name="edit_user_form">
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
                    <td class="tableColumnWidth">
                        <input type="text" name="user[login_name]" value="<?php echo isset($user['login_name']) ? $user['login_name'] : null ?>" class="text_input" />
                    </td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight errorMsg">
                    <?php if ($editUserForm['login_name']->hasError()) { ?>
                    <?php echo $editUserForm['login_name']->renderError() ?>
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

                <?php if (count($userLang) > 0) { ?>
               <tr id="displayLangId">
                    <td class="tableIndexColumn">&nbsp;</td>
                    <td class="tableColumnWidth removeLeftDotLine">
                        <?php echo __('languages', null, 'userManagementMessages') ?>
                    </td>
                    <td>
                            <?php if( count($langList) > 0) { ?>
                        <table style="width: 250px; background: none; border-collapse: none; border-top: none ; border-bottom: none ">
                                <tr>
                                    <!-- Display Checked Values -->
                                    <?php $displayLangList = $langList ;?>
                                    <?php foreach ($userLang as $savedLang) {  ?>
                                        <?php foreach ($langList as $id => $language) { ?>
                                           
                                            <?php $key = $langList->key()?>
                                            <?php if($savedLang['language_id'] == $language->getLanguageId()) {  ?>
                                                <?php $displayLangList->remove($key);?>
                                               
                                                <td style="border-top: none; border-left: none;">
                                                    <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getLanguageId() ?>" checked="true"/>
                                                    <?php echo $language->getLanguageCode()?>
                                                </td>                                          
                                                                                          
                                            <?php } ?>
                                        <?php } ?>
                                                                                                          
                                    <?php } ?>
                                   
                                          <?php if(count($displayLangList) > 0) { ?>
                                             
                                                        <?php foreach ($displayLangList as $lang) { ?>
                                                            <td style="border-top: none; border-left: none;">
                                                                <input type="checkbox" name="user[user_languages][]" value="<?php echo $lang->getLanguageId() ?>" />
                                                                <?php echo $lang->getLanguageCode()?>
                                                            </td>
                                                        <?php }?>
                                    <?php }?>
                                     
                                </tr>
                            </table>
                            <?php } ?>
                    </td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight">&nbsp;</td>
                </tr>
                <?php }  else { ?>
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
                                        <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getLanguageId() ?>" />
                                                <?php echo $language->getLanguageCode()?>
                                    </td>                               
                                <?php } ?>
                                </tr>
                            </table>
                            <?php } ?>
                    </td>
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight">&nbsp;</td>
                </tr>
                <?php } ?>
                 <tr>
                    <td>&nbsp;</td>
                    <td  class="removeLeftDotLine">&nbsp;</td>
                    <td>
                        <input type="hidden" name="user[password]" value="<?php echo isset($user['login_name']) ? $user['login_name'] : null ?>" />
                        <input type="hidden" name="user[user_id]" value="<?php echo isset($user['user_id']) ? $user['user_id'] : null ?>" />
                        <input type="button" name="update_user" id="update_user" class="button normalText" value="<?php echo __('update', null, 'localizationMessages') ?>" />
                        <input type="button" name="cancel_user" id="cancel_user" class="button normalText" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
                    </td>
                    <td class="removeLeftDotLine addDotLinetoRight">&nbsp;</td>
                </tr>

            </table>
        </form>
    </div>
</div>
