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

            try {
                $role = sfContext::getInstance()->getUser()->getUserRole();
                $result = false;
                if (array_search($targetLanguageId, $role->getAllowedLanguageList()) != null)
                    $result = $this->localizationService->generateDictionary($sourceLanguageId, $targetLanguageId);

                if (!$result) {
                    $this->getResponse()->setError('Error');
                }
            } catch (Exception $ex) {
                $this->getResponse()->setError('Error');
            }
        }

//        if ($request->getParameter('return') == 'download')
//            $this->redirect('@download_dictionary?targetLanguageId=' . $targetLanguageId);

        $this->setTemplate('index');
    }

}
?>
