<script type="text/javascript">
    var isFormSaved = true;
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
    
    var makeConnectionAliveAjaxActionUrl = '<?php echo url_for('localization/makeConnectionAliveAjax');?>';
    window.setInterval(function() {
         $.ajax(
            {
                type: "POST",
                url: makeConnectionAliveAjaxActionUrl,
                success:
                    function(responseData)
                    {
                         
                    },
                error:
                    function()
                    {
			alert("Please Save Your Translated Strings and Continue")
                    }
            });
}, 3*60*1000);
  
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
            <?php echo __('translate_text', null, 'localizationMessages') ?>
        </div>
        <form id="language_search_form" class ="pagination_enabled" name="language_search_form" action="<?php echo url_for('localization/viewTranslateText')?>" method="post">
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
        </table>
        <?php include_partial('localization/mandetoryFieldMessage')?>
        <input type="submit" name="display" id="dispay" class="button normalText" value="<?php echo __('display', null, 'localizationMessages') ?>" />&nbsp;
        </form>
    </div>
</div>

<?php if(count($listValues) > 0) {?>
<div class="aouterBorder">

    <div class="homePage">
    <div class="listMessageBar">
        <?php if($sf_user->getFlash('editErrorMessage') != '') { ?>
            <span class="error"><?php echo $sf_user->getFlash('editErrorMessage'); ?></span>
        <?php } else if($sf_user->getFlash('editSuccessmessage') != '') { ?>
            <span class="success"><?php   echo $sf_user->getFlash('editSuccessmessage');?></span>
        <?php } ?>
    </div>
    <form action="<?php echo url_for('localization/saveTranslateText')?>" method="post" id="show_label_form" name="show_label_form">
    <input type="hidden" name="add_label[language_group_id]" value="<?php echo $languageGroupId;?>"/>
    <input type="hidden" name="languageList" value="<?php echo $targetLanguageId;?>"/>
    <input type="hidden" id="saveFormPageNo" name="pageNo" value="<?php echo $pageNo?>"/>
    <div class="paginate_component">
        <?php if ($pager->haveToPaginate()) {?>
            <?php include_partial('paging_links_js', array('pager' => $pager, 'location' => 'top'));?>
        <?php } ?>
    </div>
        <div class="mediumText pageHeader buttonDiv">
            <table class="mainFrame">
                <tr>
                    <td>
                        <input type="submit" name="save" id="save" class="button normalText" value="<?php echo __('save', null, 'localizationMessages') ?>"/>
                        <input type="button" name="edit" id="edit" class="button normalText" value="<?php echo __('edit', null, 'localizationMessages') ?>"/>
                        <input type="reset" name="cancel" id="cancel" class="button normalText" value="<?php echo __('cancel', null, 'localizationMessages') ?>"/>
                    </td>
                    <td class="viewTanslateTextmessage removeLeftDotLine removetopDotLine">
                        <span id="TranslateTextHelpText">Text to be translated are highlighted </span>
                    </td>
                </tr>
            </table>
        </div>
        <table class="mainFrame mediumText dataList">
            <thead>
                    <th></th>
                    <th><?php echo __('source_label', null, 'localizationMessages')?></th>
                    <th><?php echo __('source_note', null, 'localizationMessages')?></th>
                    <th><?php echo __('target_label', null, 'localizationMessages')?></th>
                    <th><?php echo __('target_note', null, 'localizationMessages')?></th>
            </thead>
            <tbody>
                <?php $count = 1 ?>
                <?php foreach ($listValues as $sourceId => $item) : ?>
                    <tr class="<?php echo $sourceId;?>">
                            <td><?php echo $offset + $count;?></td>
                            <td class="source_label <?php echo $sourceId;?>">
                             <?php
                            $specialCharacterPostion = strpos($item['sourceValue'], '%');
                            if($specialCharacterPostion === FALSE){
                                echo $item['sourceValue'];
                            }
                            else{
                                $strings = array();
                                $strings[] = $item['sourceValue'];

                                $formattedStrings = array();
                                foreach ($strings as $string) {
                                preg_match_all("/(\%.*?\%)/", $string, $matches);

                                if (array_key_exists(0, $matches)) {
                                    $uniqueMatchArray = array_unique($matches[0]);
    
                                    foreach ($uniqueMatchArray as $match) {
                                            $string = str_replace($match,"<span class='specialStringRedBg'>{$match}</span>", $string);
                                            }
                                    }
    
                                $formattedStrings[] = $string;

                                }
                            foreach($formattedStrings as $key=>$value)
                                {
                                echo $value;
                                }?>
                                <a href="#"><span id="erorrToolTip" class="tootlTip" title="Do Not Translate the Phrase Marked in Red"><img src="<?php echo image_path('warning-icon.gif')?>" width="15" height="15" /> </span></a>
                                <?php
                            }
                            ?>
                            </td>
                            <td class="source_note <?php echo $sourceId;?>"><?php echo $item['sourceNote'];?></td>
                    <?php if(!empty($item['targetId'])) : ?>
                            <td class="target_label <?php echo $sourceId;?>"><input name="targetLabel[<?php echo $sourceId;?>][<?php echo $item['targetId'];?>]" class="target_label_input <?php echo $item['targetId'];?>" type="text" value="<?php echo $item['targetValue'];?>"/></td>
                            <td class="target_note <?php echo $sourceId;?>"><textarea  name="targetNote[<?php echo $sourceId;?>][<?php echo $item['targetId'];?>]" class="target_note_input <?php echo $item['targetId'];?>" type="text"><?php echo $item['targetNote'];?></textarea></td>
                    <?php else : ?>
                           <td class="target_label <?php echo $sourceId;?>"><input name="targetLabel[<?php echo $sourceId;?>][<?php echo -1;?>]" class="target_label_input" type="text" value=""/></td>
                            <td class="addDotLinetoRight target_note <?php echo $sourceId;?>"><textarea  name="targetNote[<?php echo $sourceId;?>][<?php echo -1;?>]" class="target_note_input" type="text"></textarea></td>
                    <?php endif; ?>

                     </tr>
                     <?php $count++; endforeach; ?>                
                
                
                
                
                
                
                
                
            </tbody>
        </table>
    </form>
    </div>
</div>

<?php }?>