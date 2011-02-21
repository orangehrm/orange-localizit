<div class="mainFrame">
    <div class="mainLogo">
        Orange-Localizit
    </div>
    <div class="normalText float-right logout">
        <?php
        echo link_to('Logout', 'authentication/logout');
        ?>
    </div>
    <div class="normalText float-right">
        Welcome <span class="boldText"><?php echo '&lsquo;' . $sf_user->getAttribute('username') . '&rsquo;' ?> </span>
    </div>
</div>
