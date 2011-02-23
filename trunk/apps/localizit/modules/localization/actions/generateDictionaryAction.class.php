<?php
/**
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2006 Orange-localizit Inc., http://www.orange-localizit.com
 *
 * Orange-localizit is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * Orange-localizit is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

/**
 * This action generats language dictionary file for selected source-target languages
 *
 * @author Chameera S
 */
class generateDictionaryAction extends sfAction {

    private $localizationService;

    /**
     * This method is executed before each action
     */
    public function preExecute() {
        $this->localizationService = $this->getLocalizationService();
    }

    /**
     * Get Localization Service
     */
    public function getLocalizationService() {
        $this->localizationService = new LocalizationService();
        $this->localizationService->setLocalizationDao(new LocalizationDao());
        return $this->localizationService;
    }

    /**
     * Generate XML Method.
     * @param <type> $request
     */
    public function execute($request) {

        if ($request->isMethod(sfRequest::GET)) {
            $sourceLanguageId = $this->getUser()->getAttribute('user_language_id');
            $targetLanguageId = $request->getParameter('targetLanguageId');

            $sourceLanguageLabel = $this->getUser()->getCulture();
            $targetLanguageLabel = $this->localizationService->getLanguageById($targetLanguageId)->getLanguageCode();
            $date = date('Y-m-d\TG:i:s\Z');

            $xml_string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">
<xliff version="1.0">
<header/>
</xliff>
XML;

            $xml = new SimpleXMLElement($xml_string);

            $languageLabelDataSet = $this->localizationService->getLabelAndLangDataSet($sourceLanguageId, $targetLanguageId);

            $cont = 1; // loop counter
            $file = $xml->addChild('file');
            $file->addAttribute('source-language', $sourceLanguageLabel);
            $file->addAttribute('target-language', $targetLanguageLabel);
            $file->addAttribute('datatype', 'plaintext');
            $file->addAttribute('original', 'messages');
            $file->addAttribute('date', $date);
            $file->addAttribute('product-name', 'messages');

            $body = $file->addChild('body');

            foreach ($languageLabelDataSet as $labelId => $languageLabelData) {
                $labelInnerData = $languageLabelData[$labelId];

                $transunit = $body->addChild('trans-unit');
                $transunit->addAttribute('id', $cont);
                $transunit->addChild('source', $labelInnerData['source_language_label']);
                $transunit->addChild('target', $labelInnerData['target_language_label']);
                $cont++;
            }

            //$xml->asXML('test_file.xml');
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            //echo $dom->saveXML();

            $myFile = "language_files/messages." . $targetLanguageLabel . ".xml";
            $fh = fopen($myFile, 'w') or die("can't open file");
            fwrite($fh, $dom->saveXML());
            fclose($fh);
        }

        if($request->getParameter('return') == 'download')
            $this->redirect ('@download_dictionary?targetLanguageId='.$targetLanguageId);

        $this->setTemplate('index');
    }
}
?>
