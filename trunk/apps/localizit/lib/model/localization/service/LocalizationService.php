<?php

/**
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2011 Orange-localizit Inc., http://www.orange-localizit.com
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
 * Description of DefineKpiService
 *
 * @author Samantha Jayasinghe
 */
class LocalizationService extends BaseService {

    private $localizationDao;

    public function getLocalizationDao() {
        return $this->localizationDao;
    }

    public function setLocalizationDao(LocalizationDao $locaizationDao) {
        $this->localizationDao = $locaizationDao;
    }

    /**
     * Add new label
     * @param $labelName,$labelComment
     * @throws ServiceException
     * @return Label
     */
    public function addLabel($labelName, $labelComment) {

        $localizationDao = $this->getLocalizationDao();

        try {
            $label = new Label();
            $label->setLabelName($labelName);
            $label->setLabelComment($labelComment);
            $label->setLabelStatus(sfConfig::get('app_status_enabled'));

            $res = $localizationDao->addLabel($label);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get label
     * @param $labelName
     * @throws ServiceException
     * @return Label
     */
    public function getLabelByName($labelName) {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->getLabelByName($labelName);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Update Label
     * @param Label $label
     * @returns boolean
     * @throws DaoException
     */
    public function updateLabel(Label $label) {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->updateLabel($label);
            return $res;
        } catch (Exception $exc) {

            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get Language List
     * @returns Language Collection
     * @return Label
     */
    public function getLanguageList() {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->getDataList('Language');
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get Language By Code
     * @param string $languageCode
     * @return Label
     */
    public function getLanguageByCode($languageCode) {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->getLanguageByCode($languageCode);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get Language By Id
     * @param int $languageId
     * @return Label
     */
    public function getLanguageById($languageId) {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->getLanguageById($languageId);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get Label and Language set by source and targetLanguage
     * @param $sourceLanguageId,$targetLanguageId
     * @param string $languageCode
     * @return array
     */
    public function getLabelAndLangDataSet($sourceLanguageId, $targetLanguageId) {

        $localizationDao = $this->getLocalizationDao();
        $dataSet = array();
        try {
            $labelList = $localizationDao->getDataList('Label');
            $languageLabelSet = $localizationDao->getLangStrBySrcAndTargetIds($sourceLanguageId, $targetLanguageId);

            if ($labelList) {

                foreach ($labelList as $label) {



                    $dataRow[$label->getLabelId()]['label_id'] = $label->getLabelId();
                    $dataRow[$label->getLabelId()]['label_name'] = $label->getLabelName();

                    foreach ($languageLabelSet as $languageLabel) {

                        if ($languageLabel->getLanguageLabelStringStatus() == sfConfig::get('app_status_enabled')) {

                            if ($label->getLabelId() == $languageLabel->getLabelId()) {

                                if ($sourceLanguageId == $languageLabel->getLanguageId()) {

                                    $dataRow[$label->getLabelId()]['source_language_label_string_id'] = $languageLabel->getLanguageLabelStringId();
                                    $dataRow[$label->getLabelId()]['source_language_id'] = $languageLabel->getLanguageId();
                                    $dataRow[$label->getLabelId()]['source_language_label'] = $languageLabel->getLanguageLabelString();
                                    $dataRow[$label->getLabelId()]['comment'] = $label->getLabelComment();
                                } elseif ($targetLanguageId == $languageLabel->getLanguageId()) {
                                    $dataRow[$label->getLabelId()]['target_language_label_string_id'] = $languageLabel->getLanguageLabelStringId();
                                    $dataRow[$label->getLabelId()]['target_language_id'] = $languageLabel->getLanguageId();
                                    $dataRow[$label->getLabelId()]['target_language_label'] = $languageLabel->getLanguageLabelString();
                                }
                            }
                        }
                    }
                    $dataSet[$label->getLabelId()] = $dataRow;
                }
            }
            return $dataSet;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Create Language String
     * @param LanguageLabelString $lls
     * @returns LanguageLabelString
     * @throws ServiceException
     */
    public function addLangStr(LanguageLabelString $lls) {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->addLangStr($lls);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Update Language String
     * @param LanguageLabelString $lls
     * @returns boolean
     * @throws ServiceException
     */
    public function updateLangStr(LanguageLabelString $lls) {
        $localizationDao = $this->getLocalizationDao();
        try {
            $res = $localizationDao->updateLangStr($lls);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Generates Language Dictionary file in XML format
     * @param $sourceLanguageId
     * @param $targetLanguageId
     * @param $sourceLanguageLabel
     * @returns boolean
     * @throws ServiceException
     */
    public function generateDictionary($sourceLanguageId, $targetLanguageId) {

        try {

            $targetLanguageLabel = $this->getLanguageById($targetLanguageId)->getLanguageCode();
            $sourceLanguageLabel = $this->getLanguageById($sourceLanguageId)->getLanguageCode();
            $date = date('Y-m-d\TG:i:s\Z');

            $xmlString = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">
<xliff version="1.0">
<header/>
</xliff>
XML;

            $xml = new SimpleXMLElement($xmlString);

            $languageLabelDataSet = $this->getLabelAndLangDataSet($sourceLanguageId, $targetLanguageId);

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

            $languageFile = sfConfig::get('sf_web_dir') . "/language_files/messages." . $targetLanguageLabel . ".xml";
            $fh = fopen($languageFile, 'w');
            if ($fh) {
                $formatted = $this->formatXmlString($xml->saveXML());
                $out = fwrite($fh, $formatted);
                fclose($fh);
            } else {
                throw new ServiceException("can't open file");
            }

            return TRUE;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * formats the xml
     * @param $xml
     * @returns String
     */
    function formatXmlString($xml) {

        // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
        $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

        // now indent the tags
        $token = strtok($xml, "\n");
        $result = ''; // holds formatted version as it is built
        $pad = 0; // initial indent
        $matches = array(); // returns from preg_matches()
        // scan each line and adjust indent based on opening/closing tags
        while ($token !== false) :

            // test for the various tag states
            // 1. open and closing tags on same line - no change
            if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) :
                $indent = 0;
            // 2. closing tag - outdent now
            elseif (preg_match('/^<\/\w/', $token, $matches)) :
                $pad--;
            // 3. opening tag - don't pad this one, only subsequent tags
            elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
                $indent = 1;
            // 4. no indentation needed
            else :
                $indent = 0;
            endif;

            // pad the line with the required number of leading spaces
            $line = str_pad($token, strlen($token) + $pad, ' ', STR_PAD_LEFT);
            $result .= $line . "\n"; // add to the cumulative result, with linefeed
            $token = strtok("\n"); // get the next token
            $pad += $indent; // update the pad size for subsequent lines
        endwhile;

        return $result;
    }

    /**
     * Download Language Dictionary file
     * @param $file
     * @returns boolean
     * @throws ServiceException
     */
    public function downloadDictionary($file) {

        try {
            //file headers --
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            ob_clean();
            flush();
            readfile($file);

            return TRUE;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }
}