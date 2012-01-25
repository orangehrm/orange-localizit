<script type="text/javascript">
    $(".sf-menu li.translateText").addClass("current");
    var languageArray = new Array();
    var i = 0;
    <?php 
        foreach ($languageIds as $id) {
            ?>
            languageArray[i] = <?php echo $id->getLanguageId() ?>;
            i++;
            <?php 
        }
    ?>
    var userType = "<?php echo $role->getUserType();?>";
    var setLanguageId = "<?php echo $targetLanguageId;?>";
    var languageGroupId = "<?php echo $languageGroupId?>";
</script>
<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('translate_text', null, 'localizationMessages') ?>
        </div>
        <span class="errorMsg"><?php echo $sf_user->getFlash('message'); ?></span>
        <form id="language_search_form" name="language_search_form" action="" method="post">
        <table class="mainFrame mediumText">
            <tr class="mainRowWidth">
                <td class="tableColumnWidth"><?php echo __('source_language', null, 'localizationMessages') ?></td>
                <td class="tableColumnWidth addDotLinetoRight"><?php echo $sourceLanguage->getName()." (". $sourceLanguage->getCode().")"; ?></td>
            </tr>
            <tr>
                <td class=""><?php echo __('target_language', null, 'localizationMessages') ?></td>
                <td class="addDotLinetoRight"><?php include_component('localization', 'LanguageList'); ?></td>
            </tr>
            <tr>
                <td><?php echo __('language_group', null, 'localizationMessages') ?></td>
                <td><?php include_component('localization', 'GroupList')?></td>
            </tr>
            <table>
                <tr>
                    <div class="formBorder">
                            <div class="formCellOne">
                                <input type="submit" name="display" id="dispay" class="button normalText" value="<?php echo __('display', null, 'localizationMessages') ?>" />&nbsp;
                            </div>
                     </div>                                       
                </tr>
            </table>
        </table>
        </form>
    </div>
</div>
<?php if($sourceList) {?>
<div class="aouterBorder">
    <div class="homePage">
    <form action="localization/saveTranslateText" method="post" id="show_label_form" name="show_label_form">
    <input type="hidden" name="add_label[language_group_id]" value="<?php echo $languageGroupId;?>"/>
    <input type="hidden" name="languageList" value="<?php echo $targetLanguageId;?>"/>
        <div class="mediumText pageHeader">
            <table class="mainFrame">
                <tr>
                    <td>
                        <input type="submit" name="save" id="save" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>"/>
                        <input type="button" name="edit" id="edit" class="button normalText" value="<?php echo __('edit', null, 'localizationMessages') ?>"/>
                        <input type="reset" name="cancel" id="cancel" class="button normalText" value="<?php echo __('cancel', null, 'localizationMessages') ?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <table class="mainFrame mediumText">
            <thead>
                    <th></th>
                    <th><?php echo __('source_label', null, 'localizationMessages')?></th>
                    <th><?php echo __('source_note', null, 'localizationMessages')?></th>
                    <th><?php echo __('target_label', null, 'localizationMessages')?></th>
                    <th><?php echo __('target_note', null, 'localizationMessages')?></th>
            </thead>
            <tbody>
                <?php $count = 1 ?>
                <?php foreach ($sourceList as $source) {
                    $targets = $source->getTarget(); ?>
                    <tr class="<?php echo $source->getId();?>">
                            <td><?php echo $count;?></td>
                            <td class="source_label <?php echo $source->getId();?>"><?php echo $source->getValue();?></td>
                            <td class="source_note <?php echo $source->getId();?>"><?php echo $source->getNote();?></td>
                    <?php if(count($targets) > 0) {?>
                    <?php  foreach ($targets as $target) {
                 ?>
                        
                            <td class="target_label <?php echo $source->getId();?>"><input name="targetLabel[<?php echo $source->getId();?>][<?php echo $target->getId();?>]" class="target_label_input <?php echo $target->getId();?>" type="text" value="<?php echo $target->getValue();?>"/></td>
                            <td class="target_note <?php echo $source->getId();?>"><textarea  name="targetNote[<?php echo $source->getId();?>][<?php echo $target->getId();?>]" class="target_note_input <?php echo $target->getId();?>" type="text"><?php echo $target->getNote();?></textarea></td>
                       
                 <?php 
                    }
                    } else { 
                        ?>
                            <td class="target_label <?php echo $source->getId();?>"><input name="targetLabel[<?php echo $source->getId();?>][<?php echo -1;?>]" class="target_label_input" type="text" value=""/></td>
                            <td class="target_note <?php echo $source->getId();?>"><input  name="targetNote[<?php echo $source->getId();?>][<?php echo -1;?>]" class="target_note_input" type="text" value=""/></td>
            <?php 
                    }
                    ?>
                     </tr>
                     <?php $count++;
                }
                        
                ?>
            </tbody>
        </table>
    </form>
    </div>
</div>

<?php }?>