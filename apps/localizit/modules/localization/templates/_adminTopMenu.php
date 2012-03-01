<div class="clear"></div>
<table class="mainFrame menuBackground">
    <tr>
        <td>
            <ul class="sf-menu">
                <?php if (sfContext::getInstance()->getUser()->isAuthenticated()) { ?>
                <li class="homepage">
                    <a href="<?php echo url_for('@homepage'); ?>"><?php echo __('download_dictionary', null, 'localizationMessages') ?></a>
                </li>
                <?php } ?>
                    <?php if (sfContext::getInstance()->getUser()->getUserRole()->isAllowedToTranslateText()) { ?>
                <li class="translateText">
                    <a href="<?php echo url_for('@translate_text'); ?>"><?php echo __('translate_text', null, 'localizationMessages') ?></a>
                </li>
                    <?php } ?>
                    <?php if (sfContext::getInstance()->getUser()->getUserRole()->isAllowedToAddLanguageGroup()) { ?>
                <li class="manageLabels">
                    <a href="<?php echo url_for('@manage_labels'); ?>"><?php echo __('manage_labels', null, 'localizationMessages') ?></a>
                </li>
                    <?php } ?>
                    <?php if (sfContext::getInstance()->getUser()->getUserRole()->isAllowedToManageUser()) { ?>
                <li class="group">
                    <a href="<?php echo url_for('@language_group_list'); ?>"><?php echo __('group', null, 'localizationMessages') ?></a>
                </li>
                <li class="userManagement">
                        <a href="<?php echo url_for('@userManagement'); ?>"><?php echo __('users', null, 'localizationMessages') ?></a>
                    <?php } ?>
                </li>
                <?php if (sfContext::getInstance()->getUser()->isAuthenticated()) { ?>
                <li class="help">
                    <a href="<?php echo url_for('@help'); ?>"><?php echo __('help', null, 'localizationMessages') ?></a>
                </li>
                <?php } ?>
            </ul>
        </td>
        <?php if(!$sf_user->isAuthenticated()) { ?>
            <td style="float: right;border-top: none"><?php include_partial('localization/login'); ?></td>
        <?php } ?>
    </tr>
</table>