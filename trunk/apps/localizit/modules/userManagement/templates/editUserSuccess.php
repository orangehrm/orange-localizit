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
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $editUserForm['login_name']->renderLabel(__('username', null, 'authenticationMessages')) ?> <span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth">
                        <input type="text" name="user[login_name]" value="<?php echo isset($user['username']) ? $user['username'] : null ?>" class="text_input" />
                    </td><!--
                    <td class="tableColumnWidth removeLeftDotLine addDotLinetoRight errorMsg">
                    <?php if ($editUserForm['login_name']->hasError()) { ?>
                    <?php echo $editUserForm['login_name']->renderError() ?>
                    <?php } ?>
                    </td>
                --></tr>            
                
                <tr>
                    <td class="tableColumnWidth removeLeftDotLine labelColumn">
                       <?php echo $editUserForm['user_type_id']->renderLabel(__('user_type', null, 'authenticationMessages')) ?> <span class="mandatoryStar">*</span>
                    </td>
                    <td><?php include_component('userManagement', 'UserList'); ?>
                    </td>
                </tr>

                <?php if (count($userLang) > 0) { ?>
               <tr id="displayLangId">
                    <td class="tableColumnWidth removeLeftDotLine labelColumn">
                        <?php echo __('languages', null, 'userManagementMessages'); ?> <span class="mandatoryStar">*</span>
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
                                                    <?php if($savedLang['languageId'] == $language->getId()) {  ?>
                                                    
                                                        <?php  $displayLangList->remove($key);?>
                                               
                                                        <td style="border-top: none; border-left: none;">
                                                            <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getId() ?>" checked="true"/>
                                                            <?php echo $language->getCode(); ?>
                                                        </td>                                                                                          
                                            <?php } ?>
                                        <?php } ?>                                                                                                          
                                    <?php } ?>
                                   
                                    <?php if(count($displayLangList) > 0) { ?>
                                                        <?php $j = 0; ?>
                                                            <?php while($j < count($displayLangList)) { ?>
                                                                <?php if (($displayLangList[$j]->getId() > 0)) { ?>
                                                                    <td style="border-top: none; border-left: none;">
                                                                        <input type="checkbox" name="user[user_languages][]" value="<?php echo $displayLangList[$j]->getId() ?>" />
                                                                        <?php echo $displayLangList[$j]->getCode(); ?>
                                                                    </td>
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
                <tr id="langId">
                    <td class="tableColumnWidth removeLeftDotLine labelColumn">
                        <?php echo __('languages', null, 'userManagementMessages') ?> <span class="mandatoryStar">*</span>
                    </td>
                    <td>
                            <?php if( count($langList) > 0) { ?>
                        <table style="width: 250px; background: none; border-collapse: none; border-top: none ; border-bottom: none ">
                                <tr>
                                <?php foreach ($langList as $language) { ?>                               
                                    <td style="border-top: none; border-left: none;">
                                        <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getId() ?>" />
                                                <?php echo $language->getCode()?>
                                    </td>                               
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
