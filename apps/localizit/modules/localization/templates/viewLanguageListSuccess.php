<div class="outerBorder homePageBorder">
    <div class="homePage">

        <table class="mainFrame mediumText">
            <tr>
                <td class="addDotLinetoRight"><a href="<?php echo url_for('@add_language') ?>">
                        <?php echo __('add_language', null, 'localizationMessages') ?></a>
                </td>
            </tr>
        </table>
        <?php if (count($languageList) > 0) { ?>
            <div class="mediumText pageHeader">
                <?php echo __('language_list', null, 'localizationMessages') ?>
            </div>
            <div class="messageBar manageLabels">
                
                <?php if ($sf_user->getFlash('errorMessage') != '') { ?>
                    <span class="error"><?php echo $sf_user->getFlash('errorMessage'); ?></span>
                <?php } else if ($sf_user->getFlash('successMessage') != '') { ?>
                    <span class="success"><?php echo $sf_user->getFlash('successMessage'); ?></span>
                <?php } ?>
            </div>
            <table class="mainFrame mediumText">
                <thead>
                    <tr>
                        <th><?php echo __('language_name', null, 'localizationMessages') ?></th>
                        <th><?php echo __('edit', null, 'userManagementMessages') ?></th>
                        <th><?php echo __('delete', null, 'userManagementMessages') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($languageList as $language): ?>
                        <tr>
                            <td><?php echo $language->getName() . ' (' . $language->getCode() . ')' ?></td>
                            <td style="text-align: center"><a href="<?php echo url_for('@edit_language?id=' . $language->getId()) ?>"><span  class="imageLink"><?php echo image_tag('edit.gif', array('border' => '0')) ?></span></a></td>
                            <td class="addDotLinetoRight" style="text-align: center"><a href="#"><span  class="imageLink"><?php echo image_tag('delete.gif', array('onclick' => 'deleteLanguage(' . $language->getId() . ')', 'border' => '0')) ?></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(".sf-menu li.language").addClass("current");
    var langId = '<?php echo $language->getId()?>';
</script>

