<script type="text/javascript">
    $(".sf-menu li.userManagement").addClass("current");
</script>
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
                    <td  class="tableColumnWidth labelColumn"><?php echo $editUserForm['first_name']->renderLabel(__('first_name', null, 'userManagementMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth addDotLinetoRight">
                        <input type="text" name="user[first_name]" value="<?php echo isset($user['firstName']) ? $user['firstName'] : null ?>" class="text_input" />
                    <div class="errorMsg">
                    <?php if ($editUserForm['first_name']->hasError()) { ?>
                    <?php echo $editUserForm['first_name']->renderError() ?>
                    <?php } ?>
                    </div>
                </tr><tr>
                    <td  class="tableColumnWidth labelColumn"><?php echo $editUserForm['last_name']->renderLabel(__('last_name', null, 'userManagementMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth addDotLinetoRight">
                        <input type="text" name="user[last_name]" value="<?php echo isset($user['lastName']) ? $user['lastName'] : null ?>" class="text_input" />
                    <div class="errorMsg">
                    <?php if ($editUserForm['last_name']->hasError()) { ?>
                    <?php echo $editUserForm['last_name']->renderError() ?>
                    <?php } ?>
                    </div>
                </tr>
                <tr>
                    <td  class="tableColumnWidth labelColumn"><?php echo $editUserForm['email']->renderLabel(__('email', null, 'userManagementMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth addDotLinetoRight">
                        <input type="text" name="user[email]" value="<?php echo isset($user['email']) ? $user['email'] : null ?>" class="text_input" />
                    <div class="errorMsg">
                    <?php if ($editUserForm['email']->hasError()) { ?>
                    <?php echo $editUserForm['email']->renderError() ?>
                    <?php } ?>
                    </div>
                </tr>
                <tr>
                    <td  class="tableColumnWidth labelColumn"><?php echo $editUserForm['login_name']->renderLabel(__('username', null, 'authenticationMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth addDotLinetoRight">
                        <input type="text" name="user[login_name]" value="<?php echo isset($user['username']) ? $user['username'] : null ?>" class="text_input" />
                    <div class="errorMsg">
                    <?php if ($editUserForm['login_name']->hasError()) { ?>
                    <?php echo $editUserForm['login_name']->renderError() ?>
                    <?php } ?>
                    </div>
                </tr>
                <tr>
                    <td class="tableColumnWidth  labelColumn">
                       <?php echo $editUserForm['user_type_id']->renderLabel(__('user_type', null, 'authenticationMessages')) ?> <span class="mandatoryStar">*</span>
                    </td>
                    <td class="addDotLinetoRight"><?php include_component('userManagement', 'UserList'); ?>
                    </td>
                </tr>

                <?php if (count($userLang) > 0) { ?>
                <?php $count=0;?>
               <tr id="displayLangId">
                    <td class="tableColumnWidth  labelColumn">
                        <?php echo __('languages', null, 'userManagementMessages'); ?> <span class="mandatoryStar">*</span>
                    </td>
                    <td class="addDotLinetoRight">
                            <?php if( count($langList) > 0) { ?>
                        <table style="width: 95%; background: none; border-collapse: none; border-top: none ; border-bottom: none ">
                                <tr>
                                    <!-- Display Checked Values -->
                                    <?php $displayLangList = $langList ;?>
                                        <?php foreach ($userLang as $savedLang) {  ?>
                                           <?php foreach ($langList as $id => $language) { ?>
                                           <?php if($language->getCode() != "en_US") {?> 
                                                <?php $key = $langList->key()?>
                                                    <?php if($savedLang['languageId'] == $language->getId()) {  ?>
                                                        <?php $count++;?>
                                                        <?php if($count%3 == 0) {?> 
                                                            <?php echo "</tr><tr>";?>
                                                        <?php }?>
                                                        <?php  $displayLangList->remove($key);?>
                                                
                                                        <td class="languageCell addDotLinetoRight" style="border-top: none; border-left: none;">
                                                            <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getId() ?>" checked="true"/>
                                                            <?php echo trim($language->getName()."(".$language->getCode().")")?>
                                                        </td>                                                                                          
                                            <?php } ?>
                                        <?php } ?>
                                        <?php }?>                                                                                                          
                                    <?php } ?>
                                   
                                    <?php if(count($displayLangList) > 0) { ?>
                                                        <?php $j = 0; ?>
                                                            <?php while($j < count($displayLangList)) { ?>
                                                            <?php if($displayLangList[$j]->getCode() != "en_US") {?> 
                                                                <?php if (($displayLangList[$j]->getId() > 0)) { ?>
                                                                    <?php $count++;?>
                                                                    <?php if($count%3 == 0) {?> 
                                                                        <?php echo "</tr><tr>";?>
                                                                    <?php }?>
                                                                    <td class="languageCell addDotLinetoRight" style="border-top: none; border-left: none;">
                                                                        <input type="checkbox" name="user[user_languages][]" value="<?php echo $displayLangList[$j]->getId() ?>" />
                                                                        <?php echo trim($displayLangList[$j]->getName()."(".$displayLangList[$j]->getCode().")"); ?>
                                                                    </td>
                                                                <?php }?>
                                                                <?php }?>
                                                                <?php $j += 1 ;?>
                                                            <?php }?>                                                        
                                    <?php } ?>
                                     
                                </tr>
                            </table>
                            <?php } ?>
                    </td>
                </tr>
                <?php }  else { ?>
                <tr id="langId" class="addDotLinetoRight">
                    <td class="tableColumnWidth labelColumn">
                        <?php echo __('languages', null, 'userManagementMessages') ?> <span class="mandatoryStar">*</span>
                    </td>
                    <td class="addDotLinetoRight">
                            <?php if( count($langList) > 0) { ?>
                        <table style="width: 95%; background: none; border-collapse: none; border-top: none ; border-bottom: none ">
                                <tr>
                                <?php $count=0;?>
                                <?php foreach ($langList as $language) { ?>
                                <?php if($language->getCode() != "en_US") {?>
                                 <?php $count++;?>
                                 <?php if($count%3 == 0) {?> 
                                     <?php echo "</tr><tr>";?>
                                 <?php }?>
                                    <td class="languageCell"style="border-top: none; border-left: none;">
                                        <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getId() ?>" />
                                                <?php echo trim($language->getName()."(".$language->getCode().")");?>
                                    </td> 
                                    <?php }?>                              
                                <?php } ?>
                                </tr>
                            </table>
                            <?php } ?>
                    </td>
                </tr>
                <?php } ?>
                        <input type="hidden" name="user[password]" value="<?php echo isset($user['password']) ? $user['password'] : null ?>" />
                        <input type="hidden" name="user[action]" value="edit" />
                        <input type="hidden" name="user[confirm_password]" value="<?php echo isset($user['password']) ? $user['password'] : null ?>" />
                        <input type="hidden" name="user[user_id]" value="<?php echo isset($user['id']) ? $user['id'] : null ;?>" />
                </tr>

            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?>
            <input type="button" name="update_user" id="update_user" class="button normalText" value="<?php echo __('update', null, 'localizationMessages') ?>" />
            <input type="button" name="cancel_user" id="cancel_user" class="button normalText" onclick="redircetToPage('<?php echo url_for("@userManagement")?>')" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
        </form>
    </div>
</div>
