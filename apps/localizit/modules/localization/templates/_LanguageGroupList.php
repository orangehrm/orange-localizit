<select class="langueDropDownList" id="add_label_language_group_id" name="<?php if(isset($isArray)) {?>languageGroupList<?php echo "_".$prefix."[]";
        }else {?>add_label[language_group_id]<?php }?>">
            <?php if($languageGroupList) {?>
                <?php foreach ($languageGroupList as $langGroup) { ?>
                    <?php if(!isset($selected_index)) {?>
                        <?php if($langGroup->getId() !=0) {?>

    <option value="<?php echo $langGroup->getId() ?>">
            <?php echo  $langGroup->getName() ?>
    </option>
                    <?php }?>
                <?php }else {?>
    <option value="<?php echo $langGroup->getId() ?>" <?php echo $selected_index==$langGroup->getId() ? 'selected="selected"':null?>>
                    <?php echo $langGroup->getName() ?>
    </option>
                <?php }?>
            <?php }?>
        <?php }?>
</select>
