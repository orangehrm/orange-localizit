<script type="text/javascript">
    
    var userType = "<?php echo $role->getUserType();?>";
    var setLanguageId = "<?php echo $targetLanguageId;?>";
    var languageGroupId = "<?php echo $languageGroupId?>";
    
    
  
</script>
<div class="messageBar">
        <?php if($sf_user->getFlash('errorMessage') != '') { ?>
            <span class="error"><?php echo $sf_user->getFlash('errorMessage'); ?></span>
        <?php } else if($sf_user->getFlash('successMessage') != '') { ?>
            <span class="success"><?php echo $sf_user->getFlash('successMessage');?></span>
        <?php } ?>
</div>
<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('translate_statistics', null, 'localizationMessages') ?>
        </div>
        <form id="language_search_form" class ="pagination_enabled" name="language_search_form" action="<?php echo url_for('localization/viewTranslateStatistics')?>" method="post">
        <input type="hidden" id="pageNo" name="pageNo" value="1"/>
        <table class="mainFrame mediumText">
            <tr class="mainRowWidth">
                <td class="tableColumnWidth"><?php echo __('source_language', null, 'localizationMessages') ?></td>
                <td class="tableColumnWidth addDotLinetoRight"><?php echo $sourceLanguage->getName()." (". $sourceLanguage->getCode().")"; ?></td>
            </tr>
            <tr>
                <td class=""><?php echo __('target_language', null, 'localizationMessages') ?><span class="mandatoryStar">*</span></td>
                <td class="addDotLinetoRight"><?php include_component('localization', 'LanguageList'); ?></td>
            </tr>
            <tr>
                <td><?php echo __('language_group', null, 'localizationMessages') ?><span class="mandatoryStar">*</span></td>
                <td class="addDotLinetoRight"><?php include_component('localization', 'GroupList')?></td>
            </tr>
            <?php if ($showSearchFilters):?>
            <tr>
                <td><?php echo __('hide_translated', null, 'localizationMessages') ?></td>
                <td class="addDotLinetoRight"><?php echo $searchFiltersForm['translated']->render(); ?></td>
            </tr>
           
            <?php endif; ?> 
        </table>
        <?php include_partial('localization/mandetoryFieldMessage')?>
        <input type="submit" name="display" id="dispay" class="button normalText" value="<?php echo __('display', null, 'localizationMessages') ?>" />&nbsp;
        </form>
    </div>
</div>
<div class="outerBorder homePageBorder">
    <ul>
        <li><?php echo __('source_word_count', null, 'localizationMessages') ?> :<?php echo $sourceWordCount; ?></li>
        <li><?php echo __('target_word_count', null, 'localizationMessages') ?> :<?php echo $targetWordCount; ?></li>
    </ul>
    <ul>
        <li><?php echo __('source_string_count', null, 'localizationMessages') ?> :<?php echo $sourceStringCount; ?></li>
        <li><?php echo __('target_string_count', null, 'localizationMessages') ?> :<?php echo $targetStringCount; ?></li>
        <li><?php echo __('remaining_string_count', null, 'localizationMessages') ?> :<?php echo $remainigStringCount; ?></li>
    </ul>
</div>
