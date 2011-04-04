<div class="outerBorder homePageBorder">
    <div class="homePage">

        <table class="mainFrame mediumText">
            <tr>
                <td><a href="<?php echo url_for('@add_user') ?>">
                    <?php echo __('add_new_user', null, 'userManagementMessages') ?></a></td>
                <td><a href="<?php echo url_for('@add_language_group') ?>">
                    <?php echo __('add_language_group', null, 'localizationMessages') ?></a></td>
            </tr>
        </table>
        <div class="mediumText pageHeader">
            <?php echo __('language_list', null, 'userManagementMessages') ?>
        </div>
        <table class="mainFrame mediumText">
            <thead>
                <tr>
                    <th><?php echo __('group_name', null, 'userManagementMessages')?></th>
                    <th><?php echo __('edit', null, 'userManagementMessages')?></th>
                    <th><?php echo __('delete', null, 'userManagementMessages')?></th>
                </tr>
            </thead>
            <tbody><?php //echo url_for('userManagement/delete?user_id=' . $user->getUserId()) ?>
                <?php foreach ($languageGroupList as $lang): ?>
                    <tr>
                        <td><?php echo $lang->getGroupName() ?></td>
                        <td style="text-align: center"><a href="<?php echo url_for('@edit_lang_group?id=' . $lang->getId()) ?>"><span  class="imageLink"><?php echo image_tag('edit.gif' , array ('border' => '0'))?></span></a></td>
                        <td style="text-align: center"><a href="#"><span  class="imageLink"><?php echo image_tag('delete.gif' , array ('onclick' => 'deleteLangGroup('.$lang->getId().')', 'border' => '0'))?></span></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>


    </div>
</div>