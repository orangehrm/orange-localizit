<table>    
    <tr>
        <td>Source Language</td>
        <td><?php echo $sourceLanguageLabel;?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>Target Language</td>
        <td><?php include_component('localization', 'LanguageList');?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><input type="button" name="add" id="add" value="Add" /></td>
        <td>
            <input type="button" name="edit" id="edit" value="Edit" />
            <input type="button" name="save" id="save" value="save" style="display: none;"/>
        </td>
        <td><input type="button" name="generateDictionary" id="generateDictionary" value="Generate Dictionary" /></td>
    </tr>
</table>
<div class="space"></div>
<div id="dataSet" >
</div>
<input type="hidden" id="url" value="<?php echo url_for('@language_label_data_set');?>" />
<input type="hidden" id="edit_url" value="<?php echo url_for('@language_label_data_set_edit');?>" />