<?php

/**
 * This action download language dictionary file for selected target language
 *
 * @author Chameera S
 */
class downloadDictionaryAction extends sfAction {

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
     * Download XML Method.
     * @param <type> $request
     */
    public function execute($request) {

        if ($request->isMethod(sfRequest::GET)) {
            $targetLanguageId = $request->getParameter('targetLanguageId');
            $targetLanguageLabel = $this->localizationService->getLanguageById($targetLanguageId)->getLanguageCode();

            $file = "language_files/messages." . $targetLanguageLabel . ".xml";

            if (!file_exists($file)) {
                $this->redirect("@generate_dictionary?targetLanguageId=$targetLanguageId&return=download");
            }
            
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
            exit;
        }

        $this->setTemplate('index');
    }

}
?>
