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
use Project\Model\Project;          
use Project\Form\ProjectForm;

class ProjectController extends AbstractActionController
{
    protected $projectTable;
    
    public function indexAction()
    {
        return new ViewModel(array(
            'projects' => $this->getProjectTable()->fetchAll(),
        ));
    }
    
 public function showAction() {
     $id = (int) $this->params()->fromRoute('id', 0);
     if (!$id) {
     	return $this->redirect()->toRoute('project', array(
     			'action' => 'add'
     	));
     }
     $project = $this->getProjectTable()->getProjectPart($id);
     
     $form  = new ProjectForm();
     $form->bind($project);
     $form->get('submit')->setAttribute('value', 'Back');
    
     return array(
     		'id' => $id,
     		'form' => $form,
     );
 }
    
 public function addAction()
    {
        $form = new ProjectForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $project = new Project();
            $form->setInputFilter($project->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $project->exchangeArray($form->getData());
                $this->getProjectTable()->saveProjectPart($project);

                // Redirect to list of albums
                return $this->redirect()->toRoute('project');
            }
        }
        return array('form' => $form);
    }
    
public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('project', array(
                'action' => 'add'
            ));
        }
        $project = $this->getProjectTable()->getProjectPart($id);

        $form  = new ProjectForm();
        $form->bind($project);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($project->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProjectTable()->saveProjectPart($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('project');
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
            return $this->redirect()->toRoute('project');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProjectTable()->deleteProjectPart($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('project');
        }

        return array(
            'id'    => $id,
            'project' => $this->getProjectTable()->getProjectPart($id)
        );
    }

 public function getProjectTable()
    {
    	if (!$this->projectTable) {
    		$sm = $this->getServiceLocator();
    		$this->projectTable = $sm->get('Project\Model\ProjectPartTable');
    	}
    	return $this->projectTable;
    }
    
}
