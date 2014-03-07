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
 * Add A Language to the list
 */
class addLanguageAction extends sfAction {

    private $languageServie;

    public function getLanguageServie() {
        if (is_null($this->languageServie)) {
            $this->languageServie = new LanguageService();
            $this->languageServie->setLanguageDao(new LanguageDao());
        }
        return $this->languageServie;
    }

    public function execute($request) {
        if (!$this->getUser()->isAuthenticated()) {
            $this->redirect('@loginpage');
        }
        
        $this->setForm(new LocalizitLanguageForm());

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $language = $this->form->save();
                $this->getUser()->setFlash("successMessage", "Successfully Saved the Language", true);
                $this->redirect('@language_list');
            }
        }
    }

    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

}
