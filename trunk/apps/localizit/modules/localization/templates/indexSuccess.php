<script type="text/javascript">
<?php $dirname = dirname(sfConfig::get('sf_language_dir')); ?>
<?php $files = glob($dirname."/language_files/*");?>
    var fileCount = "<?php echo count($files)?>";
    $(".sf-menu li.homepage").addClass("current");
</script>
<div class="messageBar">
        <?php if($sf_user->getFlash('errorMessage') != '') { ?>
            <span class="error"><?php echo $sf_user->getFlash('errorMessage'); ?></span>
        <?php } else if($sf_user->getFlash('successMessage') != '') { ?>
            <span class="success"><?php   echo $sf_user->getFlash('successMessage');?></span>
        <?php } ?>
</div>
<div class="outerBorder homePageBorder">
    <div class="homePage">
        <div class="mediumText pageHeader">
            <?php echo __('download_dictionary', null, 'localizationMessages') ?>
        </div>
        <span class="errorMsg"><?php echo $sf_user->getFlash('message'); ?></span>
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
                <td><?php include_component('localization', 'GroupList')?></td>
            </tr>

            
            <table class="mainFrame">
                <tr>
            <?php include_partial('localization/mandetoryFieldMessage')?>
                </tr>
                <tr>
                    <?php $dirname = dirname(sfConfig::get('sf_language_dir')); ?>
                    <?php $files = glob($dirname."/language_files/*");?>
                    <?php $role = sfContext::getInstance()->getUser()->getUserRole(); ?>
                    <div class="formBorder">
                        <?php if ($role->isAllowedToGenerateDirectory()) { ?>
                    
                            <div class="formCellOne">
                                <input type="button" name="generateDictionary" id="generateDictionary" class="button normalText" value="<?php echo __('generate_dictionary', null, 'localizationMessages') ?>" />&nbsp;
                            </div>
                        <?php } ?>
                        <?php if ($role->isAllowedToDownloadDirectory() && count($files) > 0 ) { ?>
                            <div class="formCellTwo">
                               <input type="button" name="downloadDictionary" id="downloadDictionary" class="button normalText" value="<?php echo __('download_dictionary', null, 'localizationMessages') ?>" />
                        </div>
                        <?php } ?>
                     </div>                                       
            </tr>
            </table>
        </table>
    </div>
</div>