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
            $sourceLanguageLabel = $this->getUser()->getCulture();

            $file = "language_files/messages." . $targetLanguageLabel . ".xml";

            if (!file_exists($file)) {
                $this->redirect("@generate_dictionary?targetLanguageId=$targetLanguageId&return=download");
            }

            try {
                $result = $this->localizationService->downloadDictionary($file);

                if (!$result) {
                    $this->getResponse()->setError('Error');
                }
            } catch (Exception $ex) {
                $this->getResponse()->setError('Error');
            }
        }

        $this->setTemplate('index');
    }
}
?>
