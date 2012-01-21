<select class="langueDropDownList" id="add_label_language_group_id" name="<?php if(isset($isArray)) {?>languageGroupList<?php echo "_".$prefix."[]";
        }else {?>add_label[language_group_id]<?php }?>">
        <option value="0">-select-</option>
            <?php if($groupList) {?>
                <?php foreach ($groupList as $group) { ?>
                    <?php if(!isset($selected_index)) {?>
                        <?php if($group->getId() !=0) {?>

    <option value="<?php echo $group->getId() ?>">
            <?php echo  $group->getName() ?>
    </option>
                    <?php }?>
                <?php }else {?>
    <option value="<?php echo $group->getId() ?>" <?php echo $selected_index==$group->getId() ? 'selected="selected"':null?>>
                    <?php echo $group->getName() ?>
    </option>
                <?php }?>
            <?php }?>
        <?php }?>
</select>
