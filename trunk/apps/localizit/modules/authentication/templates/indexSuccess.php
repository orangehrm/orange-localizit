<div class="addLabelDiv loginForm" >
    <form action="<?php echo url_for('@sign_in'); ?>" method="post" id="sign_in_form" name="sign_in_form">
        <div class="formHeading">
            Orange-Localizit
        </div>
        <table>
            <tr>
                <td>
                    <?php echo $addSignInForm['login_name']->renderLabel('User Name') ?>
                </td>
                <td>
                    <?php echo $addSignInForm['login_name']->render() ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $addSignInForm['password']->renderLabel('Password') ?>
                </td>
                <td>
                    <?php echo $addSignInForm['password']->render() ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="button" name="login_label" id="login_label" value="Login" />
      
                    <input type="button" name="cancel_label" id="cancel_label" value="Cancel" />
                </td>
            </tr>
        </table>
    </form>
</div>
