<script type="text/javascript">
    $(".sf-menu li.userManagement").addClass("current");
</script>
<div class="messageBar">
        <?php if($sf_user->getFlash('errorMessage') != '') { ?>
            <span class="error"><?php echo $sf_user->getFlash('errorMessage'); ?></span>
        <?php } else if($sf_user->getFlash('successMessage') != '') { ?>
            <span class="success"><?php echo $sf_user->getFlash('successMessage');?></span>
        <?php } ?>
</div>
<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('new_user', null, 'userManagementMessages') ?>
        </div>
        <form action="<?php echo url_for('@add_user'); ?>" method="post" id="add_user_form" name="add_user_form">
            <?php echo $addUserForm->renderHiddenFields(); ?>
            <table class="mainFrame mediumText">
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $addUserForm['login_name']->renderLabel(__('username', null, 'authenticationMessages')) ?><span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $addUserForm['login_name']->render() ?>
                    <div class="errorMsg">
                    <?php if ($addUserForm['login_name']->hasError()) { ?>
                    <?php echo $addUserForm['login_name']->renderError() ?>
                    <?php } ?>                        
                    </div></td>
                </tr>
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $addUserForm['password']->renderLabel(__('password', null, 'authenticationMessages')) ?><span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $addUserForm['password']->render() ?>
                    <div class="errorMsg">
                    <?php if ($addUserForm['password']->hasError()) { ?>
                    <?php echo $addUserForm['password']->renderError() ?>
                    <?php } ?>                        
                    </div></tr>
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $addUserForm['confirm_password']->renderLabel(__('confirm_password', null, 'userManagementMessages')) ?><span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $addUserForm['confirm_password']->render() ?>
                    <div class="errorMsg">
                    <?php if ($addUserForm['confirm_password']->hasError()) { ?>
                    <?php echo $addUserForm['confirm_password']->renderError() ?>
                    <?php } ?>
                    </div></tr>

                <tr>
                    <td class="tableColumnWidth removeLeftDotLine labelColumn">
                       <?php echo $addUserForm['user_type_id']->renderLabel(__('user_type', null, 'authenticationMessages')) ?> <span class="mandatoryStar">*</span>
                    </td>
                    <td><?php include_component('userManagement', 'UserList'); ?>
                    </td>
                    &nbsp;
                    </td>
                </tr>
                
               <tr id="langId">
                    <td class="tableColumnWidth removeLeftDotLine labelColumn">
                        <?php echo __('languages', null, 'userManagementMessages') ?>
                    </td>
                    <td>
                            <?php if( count($langList) > 0) { ?>
                        <table style="width: 250px; background: none; border-collapse: none; border-top: none ; border-bottom: none ">
                                <tr>
                                <?php foreach ($langList as $language) { ?>
                                    <td style="border-top: none; border-left: none;">
                                        <input type="checkbox" name="user[user_languages][]" value="<?php echo $language->getId() ?>" />
                                                <?php echo $language->getName() . "(". $language->getCode() . ")"?>
                                    </td>
                                <?php } ?>
                                </tr>
                            </table>
                            <?php } ?>
                    </td>
                </tr>
                 
            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?></td>
            <input type="hidden" name="user[action]" value="add" />
            <input type="button" name="save_user" id="save_user" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>" />
            <input type="button" name="cancel_user" onclick="redircetToPage('<?php echo url_for("@userManagement")?>')" id="cancel_user" class="button normalText" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
            
        </form>
    </div>
</div>
