<?php
namespace Project\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ProjectPart
{
    public $id;
    public $name;
    public $description;
    public $objectives;
    public $conditions;
    public $startdate;
    public $enddate;
    public $effort;
    public $duration;
    public $priority;
    public $plannigstyle;
    public $lateststartdate;
    public $latestenddate;
    public $phase;
    public $progress;
    public $elementstaus;
    public $type;
    
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }
    
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->objectives = (isset($data['objectives'])) ? $data['objectives'] : null;
        $this->conditions = (isset($data['conditions'])) ? $data['conditions'] : null;
        $this->startdate = (isset($data['startdate'])) ? $data['startdate'] : null;
        $this->enddate = (isset($data['enddate'])) ? $data['enddate'] : null;
        $this->effort = (isset($data['effort'])) ? $data['effort'] : null;
        $this->duration = (isset($data['duration'])) ? $data['duration'] : null;
        $this->priority = (isset($data['priority'])) ? $data['priority'] : null;
        $this->planningstyle = (isset($data['planningstyle'])) ? $data['planningstyle'] : null;
        $this->lateststartdate = (isset($data['latestendate'])) ? $data['latestendate'] : null;
        $this->latestendate = (isset($data['latestendate'])) ? $data['latestendate'] : null;
        $this->phase = (isset($data['phase'])) ? $data['phase'] : null;
        $this->progress = (isset($data['progress'])) ? $data['progress'] : null;
        $this->elementstatus = (isset($data['elementstatus'])) ? $data['elementstatus'] : null;
        $this->type = (isset($data['type'])) ? $data['type'] : null;
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    public function getInputFilter()
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    		$factory     = new InputFactory();
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'id',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'name',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 500,
    								),
    						),
    				),
    		)));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'description',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 1000,
    								),
    						),
    				),
    		)));
    
    		$this->inputFilter = $inputFilter;
    	}
    
    	return $this->inputFilter;
    }
}