<select class="langueDropDownList" id="user_user_type_id" name="<?php if(isset($isArray)) {?>userTypeList<?php echo "_".$prefix."[]";
}else {?>user[user_type_id]<?php }?>" onchange="displayLanguageList(this.value)">
            <?php if($userTypeList) {?>
                <?php foreach ($userTypeList as $userType) { ?>
                    <?php if(!isset($selected_index)) {?>
                        <?php if($userType->getId() !=0) {?>

    <option value="<?php echo $userType->getId() ?>">
            <?php echo  $userType->getUserType() ?>
    </option>
                    <?php }?>
                <?php }else {?>
    <option value="<?php echo $userType->getId() ?>" <?php echo $selected_index==$userType->getId() ? 'selected="selected"':null?>>
                    <?php echo $userType->getUserType() ?>
    </option>
                <?php }?>
            <?php }?>
        <?php }?>
</select>
