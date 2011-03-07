<form action="<?php echo url_for('@sign_in'); ?>" method="post" id="sign_in_form" name="sign_in_form">
    <?php
    $form = new SignInForm();
    echo $form['_csrf_token']->render();
    ?>
     <?php echo __('username', null, 'authenticationMessages'); ?><input class="text_input" type="text" name="sign_in[loginName]" id="sign_in_loginName"/>
    <?php echo __('password', null, 'authenticationMessages'); ?><input class="text_input" type="password" name="sign_in[password]" id="sign_in_password"/>
    <input type="button" name="login_label" id="login" class="button normalText" value="<?php echo __('login', null , 'authenticationMessages') ?>" />
</form>