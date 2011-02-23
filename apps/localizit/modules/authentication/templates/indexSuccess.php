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
                    <?php echo $signInForm['login_name']->renderLabel( __('username', null, 'authenticationMessages')) ?>
                </td>
                <td>
                    <?php echo $signInForm['login_name']->render() ?>
                </td>
                <?php if ($signInForm['login_name']->hasError()) { ?>
                <td class="errorMsg">
                      <?php echo $signInForm['login_name']->renderError() ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    <?php echo $signInForm['password']->renderLabel( __('password', null, 'authenticationMessages')) ?>
                </td>
                <td>
                    <?php echo $signInForm['password']->render() ?>
                </td>
                <?php if ($signInForm['password']->hasError()) { ?>
                <td class="errorMsg">
                    <?php echo $signInForm['password']->renderError() ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="button" name="login_label" id="login" class="button normalText" value="<?php echo __('login', null , 'authenticationMessages') ?>" />
                    <input type="button" name="cancel_label" id="cancel_label" class="button normalText" value="<?php echo __('cancel', null , 'authenticationMessages') ?>" />
                </td>
            </tr>
        </table>
    </form>
</div>

