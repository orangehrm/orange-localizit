<div class="outerBorder homePageBorder">
    <div class="homePage">

        <table class="mainFrame mediumText">
            <tr>
                <td><a href="<?php echo url_for('@add_user') ?>">
                    <?php echo __('add_new_user', null, 'userManagementMessages') ?></a>
                </td>
            </tr>
        </table>
        <div class="mediumText pageHeader">
            <?php echo __('user_list', null, 'userManagementMessages') ?>
        </div>
        <table class="mainFrame mediumText">
            <thead>
                <tr>
                    <th><?php echo __('login_name', null, 'userManagementMessages')?></th>
                    <th><?php echo __('user_type', null, 'userManagementMessages')?></th>
                    <th><?php echo __('edit', null, 'userManagementMessages')?></th>
                    <th><?php echo __('delete', null, 'userManagementMessages')?></th>
                </tr>
            </thead>
            <tbody><?php //echo url_for('userManagement/delete?user_id=' . $user->getUserId()) ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->getLoginName() ?></td>
                        <td><?php echo $user->getUserType()->getUserType() ?></td>
                        <td style="text-align: center"><a href="<?php echo url_for('@edit_user?id=' . $user->getUserId()) ?>"><span  class="imageLink"><?php echo image_tag('edit.gif' , array ('border' => '0'))?></span></a></td>
                        <td style="text-align: center"><a href="#"><span  class="imageLink">
                        <?php if ($user->getUserId() ==1 ) { ?>
                                    -
                         <?php } else { ?>
                            <?php echo image_tag('delete.gif' , array ('onclick' => 'deleteUser('.$user->getUserId().')', 'border' => '0'))?></span></a></td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            
    </div>
</div>