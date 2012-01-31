<script type="text/javascript">
    $(".sf-menu li.userManagement").addClass("current");
</script>
<div class="outerBorder homePageBorder">
    <div class="homePage">

        <table class="mainFrame mediumText">
            <tr>
                <td class="addDotLinetoRight"><a href="<?php echo url_for('@add_user') ?>">
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
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->getUsername() ?></td>
                        <td><?php echo $user->getUserType()->getUserType() ?></td>
                        <td style="text-align: center"><a href="<?php echo url_for('@edit_user?id=' . $user->getId()) ?>"><span  class="imageLink"><?php echo image_tag('edit.gif' , array ('border' => '0'))?></span></a></td>
                        <td class="addDotLinetoRight" style="text-align: center"><a href="#"><span  class="imageLink">
                        <?php if ($user->getId() ==1 ) { ?>
                                    -
                         <?php } else { ?>
                            <?php echo image_tag('delete.gif' , array ('onclick' => 'deleteUser('.$user->getId().')', 'border' => '0'))?></span></a></td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
             </tbody>
            </table>

            
    </div>
</div>