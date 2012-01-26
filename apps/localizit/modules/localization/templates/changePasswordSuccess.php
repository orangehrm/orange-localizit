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
            <?php echo __('change password', null, 'authenticationMessages') ?>
        </div>
        <form action="<?php echo url_for('@change_password'); ?>" method="post" id="change_password_form" name="change_password_form">
            <?php echo $changePasswordForm->renderHiddenFields(); ?>

            <table class="mainFrame mediumText">
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo __('username', null, 'authenticationMessages') ?></td>
                    <td class="tableColumnWidth"><?php echo $user->getUsername()?>
                </tr>
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $changePasswordForm['current_password']->renderLabel(__('current password', null, 'authenticationMessages')) ?><span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $changePasswordForm['current_password']->render() ?><div class="errorMsg"><?php echo $changePasswordForm['current_password']->renderError() ?></div></td>
                    </tr>
                  <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $changePasswordForm['new_password']->renderLabel(__('new password', null, 'authenticationMessages')) ?><span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $changePasswordForm['new_password']->render() ?><div class="errorMsg"><?php echo $changePasswordForm['new_password']->renderError() ?></div></td>
                  </tr>
                <tr>
                    <td  class="tableColumnWidth removeLeftDotLine labelColumn"><?php echo $changePasswordForm['confirm_new_password']->renderLabel(__('confirm new password', null, 'authenticationMessages')) ?><span class="mandatoryStar">*</span></td>
                    <td class="tableColumnWidth"><?php echo $changePasswordForm['confirm_new_password']->render() ?><div class="errorMsg"><?php echo $changePasswordForm['confirm_new_password']->renderError() ?></div></td>
                    </tr>
            </table>
            <?php include_partial('localization/mandetoryFieldMessage')?></td>
            <input type="submit" name="save_user" id="save_user" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>" />
            <input type="button" name="cancel_user" onclick="redircetToPage('<?php echo url_for("@homepage")?>')" id="cancel_user" class="button normalText" value="<?php echo __('cancel', null, 'authenticationMessages') ?>" />
            
        </form>
    </div>
</div>

 