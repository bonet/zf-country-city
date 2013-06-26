<?php
namespace World\Form;

use Zend\Form\Form;
use World\Model\CountryTable;

class CityForm extends Form
{
    public function __construct(CountryTable $countryTable)
    {
        $countries = $countryTable->fetchAll();
        $countryArray = Array();
        
        foreach($countries as $country){
            $countryArray[$country->id] = $country->name;
        }
        
        // we want to ignore the name passed
        parent::__construct('city');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(     
            'type' => 'Zend\Form\Element\Select',       
            'name' => 'country_id',
            'attributes' =>  array(
                'id' => 'country_id',                
                'options' => $countryArray,
            ),
            'options' => array(
                'label' => 'Country: ',
            ),
        ));   

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}