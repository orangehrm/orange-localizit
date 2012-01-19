<div class="clear"></div>
<table class="mainFrame menuBackground">
    <tr>
        <td>
            <ul class="sf-menu">
                <li class="current">
                    <?php if (sfContext::getInstance()->getUser()->getUserRole()->isAllowedToManageUser()) { ?>
                        <a href="<?php echo url_for('@userManagement'); ?>"><?php echo __('users', null, 'localizationMessages') ?></a>
                    <?php } ?>
                </li>
                <li>
                    <a href="<?php echo url_for('@homepage'); ?>"><?php echo __('generate_dictionary', null, 'localizationMessages') ?></a>
                </li>
                    <?php if (sfContext::getInstance()->getUser()->getUserRole()->isAllowedToAddLanguageGroup()) { ?>
                <li>
                    <a href="<?php echo url_for('@language_group_list'); ?>"><?php echo __('language_group', null, 'localizationMessages') ?></a>
                </li>
                    <?php } ?>
            </ul>
        </td>
        <?php if(!$sf_user->isAuthenticated()) { ?>
            <td style="float: right;border-top: none"><?php include_partial('localization/login'); ?></td>
        <?php } ?>
    </tr>
</table>