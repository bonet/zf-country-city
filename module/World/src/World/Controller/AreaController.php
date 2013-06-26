<?php
namespace World\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use World\Model\Area;          // <-- Add this import
use World\Form\AreaForm;       // <-- Add this import

class AreaController extends AbstractActionController
{
    protected $areaTable;    
    protected $cityTable;
    
    public function indexAction()
    {
         return new ViewModel(array(
            'areas' => $this->getAreaTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
        $cm = get_class_methods($this);
        
        $form = new AreaForm($this->getCityTable());
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $area = new Area();
            $form->setInputFilter($area->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $area->exchangeArray($form->getData());
                $this->getAreaTable()->saveArea($area);

                // Redirect to list of cities
                return $this->redirect()->toRoute('area');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('area', array(
                'action' => 'add'
            ));
        }
        $area = $this->getAreaTable()->getArea($id);
        
        $form  = new AreaForm($this->getCityTable());
        $form->bind($area);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($area->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAreaTable()->saveArea($form->getData());

                // Redirect to list of cities
                return $this->redirect()->toRoute('area');
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
            return $this->redirect()->toRoute('area');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAreaTable()->deleteArea($id);
            }

            // Redirect to list of cities
            return $this->redirect()->toRoute('area');
        }

        return array(
            'id'    => $id,
            'area' => $this->getAreaTable()->getArea($id)
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
    
    
    public function getAreaTable()
    {
        
        if (!$this->areaTable) {
            $sm = $this->getServiceLocator();
            $this->areaTable = $sm->get('World\Model\AreaTable');
        }
        return $this->areaTable;
         
    }
}