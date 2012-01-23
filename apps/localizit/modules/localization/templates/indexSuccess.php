<div class="outerBorder homePageBorder">
    <div class="homePage">
        <span class="errorMsg"><?php echo $sf_user->getFlash('message'); ?></span>
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
                        <?php } ?>
                        </div>
                     </div>                                       
            </tr>
            </table>
        </table>
    </div>
</div>