<script type="text/javascript">
$(".sf-menu li.group").addClass("current");
</script>
<div class="outerBorder homePageBorder">
    <div class="homePage">

        <table class="mainFrame mediumText">
            <tr>
                <td><a href="<?php echo url_for('@add_language_group') ?>">
                    <?php echo __('add_language_group', null, 'localizationMessages') ?></a>
                </td>
            </tr>
        </table>
        <?php if(count($languageGroupList) > 0 ) { ?>
        <div class="mediumText pageHeader">
            <?php echo __('group_list', null, 'localizationMessages') ?>
        </div>
        <table class="mainFrame mediumText">
            <thead>
                <tr>
                    <th><?php echo __('group_name', null, 'localizationMessages')?></th>
                    <th><?php echo __('edit', null, 'userManagementMessages')?></th>
                    <th><?php echo __('delete', null, 'userManagementMessages')?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($languageGroupList as $lang): ?>
                    <tr>
                        <td><?php echo $lang->getName() ?></td>
                        <td style="text-align: center"><a href="<?php echo url_for('@edit_language_group?id=' . $lang->getId()) ?>"><span  class="imageLink"><?php echo image_tag('edit.gif' , array ('border' => '0'))?></span></a></td>
                        <td style="text-align: center"><a href="#"><span  class="imageLink"><?php echo image_tag('delete.gif' , array ('onclick' => 'deleteLangGroup('.$lang->getId().')', 'border' => '0'))?></span></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php } ?>
    </div>
</div>