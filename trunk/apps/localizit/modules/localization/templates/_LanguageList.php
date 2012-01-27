<select class="langueDropDownList" id="languageList" name="<?php if(isset($isArray)) {?>languageList<?php echo "_".$prefix."[]";
        }else {?>languageList<?php }?>">
        <option value="0">-select-</option>
            <?php if($languageList) {?>
                <?php foreach ($languageList as $language) { ?>
                    <?php if(!isset($selected_index)) {?>
                        <?php if($language->getId()!=$sourceLanguageId) {?>
                        <?php if($language->getCode() != "en_US") {?>
    <option value="<?php echo $language->getId() ?>">
    <?php }?>
            <?php echo $language->getName()." (".$language->getCode().")" ?>
    </option>
                    <?php }?>
                <?php }else {?>
    <option value="<?php echo $language->getId() ?>" <?php echo $selected_index==$language->getId() ? 'selected="selected"':null?>>
    <?php if($language->getCode() != "en_US") {?>
                    <?php echo $language->getName()." (".$language->getCode().")" ?>
                    <?php }?>
    </option>
                <?php }?>
            <?php }?>
        <?php }?>
</select>
