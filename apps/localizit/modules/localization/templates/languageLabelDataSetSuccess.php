<?php if($languageLabelDataSet->count() > 0) {?>

<table class="mainFrame mediumText">
    <thead>
        <tr>
            <td>&nbsp;</td>
            <td class="boldText">Label</td>
            <td class="boldText">Source Language (<?php echo $sourceLanguageLabel?>)</td>
            <td class="boldText">Target Language (<?php echo $targetLanguageLabel?>)</td>
            <td class="boldText">Language Group</td>
            <td class="boldText">Comments</td>
            <td class="addDotLinetoRight">&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($languageLabelDataSet as $labelId=>$languageLabelData) { ?>
            <?php $labelInnerData=$languageLabelData->get($labelId);?>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo isset($labelInnerData['label_name'])?$labelInnerData['label_name']:null?></td>
        <td><?php echo isset($labelInnerData['source_language_label'])?$labelInnerData['source_language_label']:null?></td>
        <td><?php echo isset($labelInnerData['target_language_label'])?$labelInnerData['target_language_label']:null?></td>
        <td><?php echo isset($labelInnerData['language_group_id'])?$labelInnerData['language_group_id']:null?></td>
        <td><?php echo isset($labelInnerData['comment'])?$labelInnerData['comment']:null?></td>
        <td class="addDotLinetoRight">&nbsp;</td>
    </tr>
            <?php }?>
    </tbody>
</table>
    <?php }?>