<?php if($languageLabelDataSet->count() > 0) {?>

<table class="mainFrame mediumText">
    <thead>
        <tr>
            <td>&nbsp;</td>
            <td>Label</td>
            <td>Source Language (<?php echo $sourceLanguageLabel?>)</td>
            <td>Target Language (<?php echo $targetLanguageLabel?>)</td>
            <td>Comments</td>
            <td>&nbsp;</td>
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
        <td><?php echo isset($labelInnerData['comment'])?$labelInnerData['comment']:null?></td>
        <td>&nbsp;</td>
    </tr>
            <?php }?>
    </tbody>
</table>
    <?php }?>