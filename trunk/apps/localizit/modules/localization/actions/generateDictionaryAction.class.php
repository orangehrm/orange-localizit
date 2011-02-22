<?php

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
            $targetLanguageLabel = $this->locdalizationService->getLanguageById($targetLanguageId)->getLanguageCode();
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

        $this->setTemplate('index');
    }

}
?>
