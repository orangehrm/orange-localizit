<select class="langueDropDownList" id="languageList" name="<?php if(isset($isArray)) {?>languageList<?php echo "_".$prefix."[]";
        }else {?>languageList<?php }?>">
            <?php if($languageList) {?>
                <?php foreach ($languageList as $language) { ?>
                    <?php if(!isset($selected_index)) {?>
                        <?php if($language->getLanguageId()!=$sourceLanguageId) {?>
    <option value="<?php echo $language->getLanguageId() ?>">
            <?php echo $language->getLanguageCode() ?>
    </option>
                    <?php }?>
                <?php }else {?>
    <option value="<?php echo $language->getLanguageId() ?>" <?php echo $selected_index==$language->getLanguageId() ? 'selected="selected"':null?>>
                    <?php echo $language->getLanguageCode() ?>
    </option>
                <?php }?>
            <?php }?>
        <?php }?>
</select>
