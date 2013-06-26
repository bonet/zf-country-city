<?php
namespace World\Form;

use Zend\Form\Form;
use World\Model\CityTable;

class AreaForm extends Form
{
    public function __construct(CityTable $cityTable)
    {
        $cities = $cityTable->fetchAll();
        $cityArray = Array();
        
        $cityArray[""] = "- Select City -";
        
        foreach($cities as $city){
            $cityArray[$city["id"]] = $city["name"] . " -- " . $city["country_name"];
        }
        
        // we want to ignore the name passed
        parent::__construct('area');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(     
            'type' => 'Zend\Form\Element\Select',       
            'name' => 'city_id',
            'attributes' =>  array(
                'id' => 'city_id',                
                'options' => $cityArray,
            ),
            'options' => array(
                'label' => 'City: ',
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