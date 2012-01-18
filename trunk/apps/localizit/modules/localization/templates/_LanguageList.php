<select class="langueDropDownList" id="languageList" name="<?php if(isset($isArray)) {?>languageList<?php echo "_".$prefix."[]";
        }else {?>languageList<?php }?>">
            <?php if($languageList) {?>
                <?php foreach ($languageList as $language) { ?>
                    <?php if(!isset($selected_index)) {?>
                        <?php if($language->getId()!=$sourceLanguageId) {?>
    <option value="<?php echo $language->getId() ?>">
            <?php echo $language->getCode() ?>
    </option>
                    <?php }?>
                <?php }else {?>
    <option value="<?php echo $language->getId() ?>" <?php echo $selected_index==$language->getId() ? 'selected="selected"':null?>>
                    <?php echo $language->getCode() ?>
    </option>
                <?php }?>
            <?php }?>
        <?php }?>
</select>
