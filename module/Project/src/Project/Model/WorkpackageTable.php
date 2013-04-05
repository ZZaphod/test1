<?php
namespace Project\Model;

use Zend\Db\TableGateway\TableGateway;

class WorkpackageTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getWorkpackage($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function saveWorkpackage(Workpackage $workpackage)
    {
    	$data = array(
    			'id' => $workpackage->id,
    			'name'  => $workpackage->name,
    	        'description'  => $workpackage->description,
    	);
    
    	$id = (int)$workpackage->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getworkpackage($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    
    public function deleteWorkpackage($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }

}