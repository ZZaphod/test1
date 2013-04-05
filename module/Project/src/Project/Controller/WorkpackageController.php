<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Project for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Project\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Project\Model\Workpackage;       
use Project\Form\WorkpackageForm;

class WorkpackageController extends AbstractActionController
{
    protected $workpackageTable;
    
    public function indexAction()
    {
        return new ViewModel(array(
            'workpackages' => $this->getWorkpackageTable()->fetchAll(),
        ));
    }
    
 public function addAction()
    {
        $form = new WorkpackageForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $workpackage = new Workpackage();
            $form->setInputFilter($workpackage->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $workpackage->exchangeArray($form->getData());
                $this->getWorkpackageTable()->saveWorkpackage($workpackage);

                // Redirect to list of albums
                return $this->redirect()->toRoute('workpackage');
            }
        }
        return array('form' => $form);
    }
    
public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('workpackage', array(
                'action' => 'add'
            ));
        }
        $workpackage = $this->getworkpackageTable()->getWorkpackage($id);

        $form  = new WorkpackageForm();
        $form->bind($workpackage);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($workpackage->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getWorkpackageTable()->saveWorkpackage($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('workpackage');
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
            return $this->redirect()->toRoute('workpackage');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getworkpackageTable()->deleteWorkpackage($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('workpackage');
        }

        return array(
            'id'    => $id,
            'workpackages' => $this->getWorkpackageTable()->getWorkpackage($id)
        );
    }

 public function getWorkpackageTable()
    {
    	if (!$this->workpackageTable) {
    		$sm = $this->getServiceLocator();
    		$this->workpackageTable = $sm->get('Project\Model\workpackageTable');
    	}
    	return $this->workpackageTable;
    }
    
}
