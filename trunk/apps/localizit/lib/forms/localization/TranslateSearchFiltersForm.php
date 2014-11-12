<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TranslateSearchFiltersForm form
 *
 */
class TranslateSearchFiltersForm extends sfForm {

    
    public function configure() {

        $this->setWidgets(array(
            'source_value' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'target_value' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'translated' => new sfWidgetFormChoice(array( 'expanded' => true, 'choices'  => 
                                           array('All',
                                                 'Translated', 
                                                 'Not Translated')))
        ));

        $this->setValidators(array(
            'source_value' => new sfValidatorString(array('required' => false)),
            'target_value' => new sfValidatorString(array('required' => false)),
            'translated' => new sfValidatorString(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('translateSearchFilters[%s]');
        
         
    }
     
}
