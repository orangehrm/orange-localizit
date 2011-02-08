<?php if($languageLabelDataSet) {?>
<form method="post" name="editLanguageLabelList" action="" id="editLanguageLabelList">
    <table >
        <thead>
            <tr>
                <td>Label</td>
                <td>Source Language (<?php echo $sourceLanguageLabel?>)</td>
                <td>Target Language (<?php echo $targetLanguageLabel?>)</td>
                <td>Comments</td>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($languageLabelDataSet as $labelId=>$languageLabelData) { ?>
                    <?php $labelInnerData=$languageLabelData->get($labelId);?>
            <tr>
                <td>
                    <input type="text" name="label_name[]" value="<?php echo isset($labelInnerData['label_name'])?$labelInnerData['label_name']:null ?>"/>
                    <input type="hidden" name="label_id[]" value="<?php echo isset($labelInnerData['label_id'])?$labelInnerData['label_id']:null ?>"/>
                </td>
                <td>
                    <input type="text" name="source_language_string[]" value="<?php echo isset($labelInnerData['source_language_label'])?$labelInnerData['source_language_label']:null ?>"/>
                    <input type="hidden" name="source_language_string_id[]" value="<?php echo isset($labelInnerData['source_language_label_string_id'])?$labelInnerData['source_language_label_string_id']:null ?>"/>
                </td>
                <td>
                    <input type="text" name="target_language_string[]" value="<?php echo isset($labelInnerData['target_language_label'])?$labelInnerData['target_language_label']:null ?>"/>
                    <input type="hidden" name="target_language_string_id[]" value="<?php echo isset($labelInnerData['target_language_label_string_id'])?$labelInnerData['target_language_label_string_id']:null ?>"/>                    
                </td>
                <td><input type="text" name="label_comment[]" value="<?php echo isset($labelInnerData['comment'])?$labelInnerData['comment']:null ?>"/></td>
            </tr>
                    <?php }?>
        </tbody>
    </table>
    <input type="hidden" id="target_language_selected_id" name="target_language_selected_id" />
</form>
    <?php }?>