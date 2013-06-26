<?php
namespace World\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use World\Model\City;          // <-- Add this import
use World\Form\CityForm;       // <-- Add this import

class CityController extends AbstractActionController
{
    protected $cityTable;
    protected $countryTable;
    
    public function indexAction()
    {
         return new ViewModel(array(
            'cities' => $this->getCityTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
        $cm = get_class_methods($this);
        
        $form = new CityForm($this->getCountryTable());
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $city = new City();
            $form->setInputFilter($city->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $city->exchangeArray($form->getData());
                $this->getCityTable()->saveCity($city);

                // Redirect to list of cities
                return $this->redirect()->toRoute('city');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('city', array(
                'action' => 'add'
            ));
        }
        $city = $this->getCityTable()->getCity($id);
        
        $form  = new CityForm($this->getCountryTable());
        $form->bind($city);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($city->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getCityTable()->saveCity($form->getData());

                // Redirect to list of cities
                return $this->redirect()->toRoute('city');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('city');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCityTable()->deleteCity($id);
            }

            // Redirect to list of cities
            return $this->redirect()->toRoute('city');
        }

        return array(
            'id'    => $id,
            'city' => $this->getCityTable()->getCity($id)
        );
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