<div class="addLabelDiv loginForm" >
    <form action="<?php echo url_for('@sign_in'); ?>" method="post" id="sign_in_form" name="sign_in_form">
        <?php echo $signInForm->renderHiddenFields(); ?>
        <div class="mainLogo">
            <?php echo __("orange_localizit", null, 'authenticationMessages'); ?>
        </div>
        <table class="mediumText">
            <?php $globalErrors=$signInForm->getGlobalErrors();
            if(count($globalErrors)>0) {
                foreach ($globalErrors as $name => $error) { ?>
            <tr>
                <td> <span class="errorMsg"><?php echo $error ?> </span></td>
            </tr>
                    <?php }
            }?>
            <tr>
                <td>
                    <?php echo $signInForm['loginName']->renderLabel( __('username', null, 'authenticationMessages')) ?>
                </td>
                <td class="addDotLinetoRight">
                    <?php echo $signInForm['loginName']->render() ?>
                </td>
                <?php if ($signInForm['loginName']->hasError()) { ?>
                <td class="errorMsg addDotLinetoRight">
                      <?php echo $signInForm['loginName']->renderError() ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    <?php echo $signInForm['password']->renderLabel( __('password', null, 'authenticationMessages')) ?>
                </td>
                <td class="addDotLinetoRight">
                    <?php echo $signInForm['password']->render() ?>
                </td>
                <?php if ($signInForm['password']->hasError()) { ?>
                <td class="errorMsg addDotLinetoRight addDotLineToBottom">
                    <?php echo $signInForm['password']->renderError() ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="addDotLinetoRight">
                    <input type="button" name="login_label" id="login" class="button normalText" value="<?php echo __('login', null , 'authenticationMessages') ?>" />
                    <input type="button" name="cancel_label" id="cancel_label" class="button normalText" value="<?php echo __('cancel', null , 'authenticationMessages') ?>" />
                </td>
                <?php if ($signInForm['password']->hasError() || $signInForm['loginName']->hasError()) { ?>
                <td class="addDotLinetoRight">&nbsp;</td>
                <?php } ?>
            </tr>
        </table>
    </form>
</div>

