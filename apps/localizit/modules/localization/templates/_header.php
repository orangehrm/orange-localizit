<div class="mainFrame">
    <div class="mainLogo">
        <?php echo __("orange_localizit", null, 'authenticationMessages'); ?>
    </div>
    <div class="normalText float-right logout">
       <?php if($sf_user->isAuthenticated()) echo link_to( __('logout', null, 'localizationMessages'), 'authentication/logout'); ?>
    </div>
    <div class="normalText float-right">
        <?php if($sf_user->isAuthenticated()) { echo __('welcome', null, 'localizationMessages'); ?> &nbsp;<span class="boldText"><?php echo '&lsquo;' . $sf_user->getAttribute('username') . '&rsquo;' ?> </span> <?php } ?>
    </div>
</div>
