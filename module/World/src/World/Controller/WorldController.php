<?php
namespace World\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use World\Model\Area;          // <-- Add this import

class WorldController extends AbstractActionController
{
    protected $countryTable;   
    protected $cityTable;       
    protected $areaTable;   
    
    public function indexAction()
    {
        $countryCityAreaJson = $this->getAreaTable()->fetchAllJSON();
        //\Zend\Debug\Debug::dump($this->getCountryTable()->fetchAll());
        
        return new ViewModel(array(
            'countryCityAreaJson' => $countryCityAreaJson,
            'countries' => $this->getCountryTable()->fetchAll(),
         ));
    }
    
    public function getAreaTable()
    {
        
        if (!$this->areaTable) {
            $sm = $this->getServiceLocator();
            $this->areaTable = $sm->get('World\Model\AreaTable');
        }
        return $this->areaTable;
         
    }
    
    public function getCityTable()
    {
        
        if (!$this->cityTable) {
            $sm = $this->getServiceLocator();
            $this->cityTable = $sm->get('World\Model\CityTable');
        }
        return $this->cityTable;
         
    }
    
    public function getCountryTable()
    {
        
        if (!$this->countryTable) {
            $sm = $this->getServiceLocator();
            $this->countryTable = $sm->get('World\Model\CountryTable');
        }
        return $this->countryTable;
         
         
    }
}
