<?php

/**
 * Instructions to merge language packs to a single file
 * Get a svn checkout from https://repos.orangehrm.com/util/languagePackUpgrader/ or copy the languagePackUpgrader folder 
 * in localizit->upgrader folder into the <product> devTools/languagePackUpgrader folder
 * Then Run the following command inside devTools/languagePackUpgrader folder
 * php languagePackUpgrader.php
 * (It will generate the language packs inside the languagePackUpgrader folder)
 * ---------------------------------------------------------------------------
 * Ex : If the product is Enterprise 4.x 
 * svn checkout https://repos.orangehrm.com/util/languagePackUpgrader/ /var/www/html/Enterprise 4.x/devTools/languagePackUpgrader/
 * php languagePackUpgrader.php (inside devTools/languagePackUpgrader/) 
*/
 
class LanguagePackUpgrader {

    private $rootPath = null;
    private $pluginsPath = null;
    private $pluginsList = array();
    private $moduleList = array();

    public function getModuleList($pluginName) {
        if (!strpbrk($pluginName, '.')) {
            if (is_dir($this->getPluginsPath() . $pluginName . '/modules/')) {
                $handle = opendir($this->getPluginsPath() . $pluginName . '/modules/');
                while ($entry = readdir($handle)) {
                    if (!strpbrk($entry, ".")) {
                        $this->moduleList[] = $entry;
                    }
                }
                return $this->moduleList;
            }
        }
        return null;
    }

    public function getRootPath() {
        if (is_null($this->rootPath)) {
            $this->rootPath = dirname(__FILE__) . '/../../';
        }
        return $this->rootPath;
    }

    public function getPluginsPath() {
        $this->pluginsPath = realpath($this->getRootPath()) . '/symfony/plugins/';
        return $this->pluginsPath;
    }

    public function getPluginsList() {
        if (is_dir($this->getPluginsPath())) {
            $handle = opendir($this->getPluginsPath());
            while ($entry = readdir($handle)) {
                if (!strpbrk($entry, '.')) {
                    $this->pluginsList[] = $entry;
                }
            }
            closedir($handle);
        }
        return $this->pluginsList;
    }

    public function getFilesList($pluginName, $moduleName) {
        $filesList = array();
        if (empty($filesList)) {
            $path = $this->getPluginsPath() . $pluginName . '/modules/' . $moduleName . '/i18n/';
            $files = glob($path . '*.xml');
            if (!empty($files)) {
                foreach ($files as $entry) {
                    $filesList[] = $entry;
                }
                return $filesList;
            }
        }
        return null;
    }

    public static function main() {
        try {
            $instance = new LanguagePackUpgrader();
            if (is_dir($instance->getPluginsPath())) {
                $pluginList = $instance->getPluginsList();
            }
            $instance->deleteUpgraderFiles();
            $fileList = $instance->getFileListInApps();
            if ($fileList) {
                $instance->processLanguagePacks($fileList);
                $instance->deleteExsistingFiles($fileList);
            }
            foreach ($pluginList as $plugin) {
                $fileList = $instance->getFileListInPlugin($plugin);
                if ($fileList) {
                    $instance->processLanguagePacks($fileList);
                    $instance->deleteExsistingFiles($fileList);
                }
                $moduleList = $instance->getModuleList($plugin);
                if ($moduleList) {
                    foreach ($moduleList as $moduleName) {
                        $fileList = $instance->getFilesList($plugin, $moduleName);
                        if ($fileList) {
                            $instance->processLanguagePacks($fileList);
                            $instance->deleteExsistingFiles($fileList);
                        }
                    }
                }
            }
            return true;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    public function getDataFromXml($file) {
        $xml = simplexml_load_file($file);
        return $xml;
    }

    public function deleteUpgraderFiles() {
        $files = glob(dirname(__FILE__) . '/*.xml');
        if (!empty($files)) {
            foreach ($files as $file) {
                unlink($file);
            }
            echo 'Files were Deleted Successfully' . "\n";
        }
    }

    public function printToXml($path, $file, $dataToPrint) {
        $fileName = basename($file, 'xml');
        $hasData = file_get_contents($path);
        $language = explode('.', basename($fileName, 'xml'));
        if ($hasData == null) {
            echo file_get_contents($path);
            $xmlString = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">
<xliff version="1.0">
<header/>
</xliff>
XML;
            $xml = new SimpleXMLElement($xmlString);
            $fileElement = $xml->addChild('file');
            $fileElement->addAttribute('source-language', 'en_US');
            $fileElement->addAttribute('target-language', $language[1]);
            $fileElement->addAttribute('datatype', 'plaintext');
            $fileElement->addAttribute('original', 'messages');
            $fileElement->addAttribute('date', date('Y-m-d\TG:i:s\Z'));
            $fileElement->addAttribute('product-name', 'messages');
            $bodyElement = $fileElement->addChild('body');
            if ($xml->asXML($path)) {
                file_put_contents(dirname(__FILE__) . '/languagePackUpgrader.log', '------ ' . $path . ' created successfully ----------' . "\n", FILE_APPEND);
            } else {
                file_put_contents(dirname(__FILE__) . '/languagePackUpgrader.log', '------ ' . $path . ' could not be able to create ----------' . "\n", FILE_APPEND);
            }
        }
        $xmlDoc = simplexml_load_file($path);
        $element = 'trans-unit';
        $countElement = count($xmlDoc->file->body->$element) + 1;
        $bodyElement = $xmlDoc->file->body;
        $sources = ($bodyElement->xpath('trans-unit/source'));
        $sourcesAsArray = array();
        foreach ($sources as $source) {
            $sourcesAsArray[] = $source->__toString();
        }
        $sourcesToPrint = array();
        $targetsToPrint = array();
        foreach ($dataToPrint as $data) {
            if (!in_array($data['source'], $sourcesToPrint)) {
                $sourcesToPrint[] = $data['source']->__toString();
                $targetsToPrint[] = $data['target']->__toString();
            }
        }
        foreach ($sourcesToPrint as $data) {
            if (!in_array($data, $sourcesAsArray)) {
                $key = array_search($data, $sourcesToPrint);
                $transElement = $bodyElement->addChild($element);
                $transElement->addAttribute('id', $countElement);
                $countElement = $countElement + 1;
                $transElement->source = $data;
                $transElement->target = $targetsToPrint[$key];
            }
        }
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xmlDoc->asXML());
        if ($dom->save($path)) {
            file_put_contents(dirname(__FILE__) . '/languagePackUpgrader.log', '------ ' . $file . ' added successfully----------' . "\n", FILE_APPEND);
        } else {
            file_put_contents(dirname(__FILE__) . '/languagePackUpgrader.log', '------ ' . $file . ' could not be able to add ----------' . "\n", FILE_APPEND);
        }
    }

    public function getFileListInPlugin($plugin) {
        $filesList = array();
        if (empty($filesList)) {
            $path = $this->getPluginsPath() . $plugin . '/i18n/';
            $files = glob($path . '*.xml');
            if (!empty($files)) {
                foreach ($files as $entry) {
                    $filesList[] = $entry;
                }
                return $filesList;
            }
        }
        return null;
    }

    public function getAppPath() {
        $path = realpath($this->getRootPath()) . '/symfony/apps/orangehrm';
        return $path;
    }

    public function getFileListInApps() {
        $filesList = array();
        if (empty($filesList)) {
            $path = $this->getAppPath() . '/i18n/';
            $files = glob($path . '*.xml');
            if (!empty($files)) {
                foreach ($files as $entry) {
                    $filesList[] = $entry;
                }
                return $filesList;
            }
        }
        return null;
    }

    public function processLanguagePacks($fileList) {
        $element = 'trans-unit';
        foreach ($fileList as $file) {
            list($prefix, $language, $extention) = explode('.', basename($file));
            $path = dirname(__FILE__) . '/messages.' . $language . '.xml';
            file_put_contents($path, null, FILE_APPEND);
            $dataFromXml = $this->getDataFromXml($file);
            $dataToPrint = array();
            foreach ($dataFromXml->file->body->$element as $data) {
                $dataToPrint[] = array('source' => $data->source, 'target' => $data->target);
            }
            $this->printToXml($path, $file, $dataToPrint);
        }
    }

    public function deleteExsistingFiles($fileList) {
        foreach ($fileList as $file) {
            $flag = unlink($file);
            if ($flag) {
                file_put_contents(dirname(__FILE__) . '/languagePackUpgrader.log', '------ ' . $file . ' deleted successfully ----------' . "\n", FILE_APPEND);
            } else {
                file_put_contents(dirname(__FILE__) . '/languagePackUpgrader.log', '------ ' . $file . ' could not be able to delete ----------' . "\n", FILE_APPEND);
            }
        }
    }

}

$result = LanguagePackUpgrader::main();
if ($result) {
    echo 'Files Created Successfully' . "\n";
} else {
    echo 'Something bad happened' . "\n";
}
