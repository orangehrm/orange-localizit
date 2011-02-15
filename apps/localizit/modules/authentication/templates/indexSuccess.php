<div class="addLabelDiv loginForm" >
    <form action="<?php echo url_for('@sign_in'); ?>" method="post" id="sign_in_form" name="sign_in_form">
        <?php echo $addSignInForm->renderHiddenFields(); ?>
        <div class="formHeading">
            Orange-Localizit
        </div>
        <table>
            <?php $globalErrors=$addSignInForm->getGlobalErrors();
            if(count($globalErrors)>0) {
                foreach ($globalErrors as $name => $error) { ?>
            <tr>
                <td> <span class="errorMsg"><?php echo $error ?> </span></td>
            </tr>
                    <?php }
            }?>
            <tr>
                <td>
                    <?php echo $addSignInForm['login_name']->renderLabel('User Name') ?>
                </td>
                <td>
                    <?php echo $addSignInForm['login_name']->render() ?>
                </td>
                <?php if ($addSignInForm['login_name']->hasError()) { ?>
                <td class="errorMsg">
                      <?php echo $addSignInForm['login_name']->renderError() ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    <?php echo $addSignInForm['password']->renderLabel('Password') ?>
                </td>
                <td>
                    <?php echo $addSignInForm['password']->render() ?>
                </td>
                <?php if ($addSignInForm['password']->hasError()) { ?>
                <td class="errorMsg">
                    <?php echo $addSignInForm['password']->renderError() ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="button" name="login_label" id="login" value="Login" />
                    <input type="button" name="cancel_label" id="cancel_label" value="Cancel" />
                </td>
            </tr>
        </table>
    </form>
</div>

