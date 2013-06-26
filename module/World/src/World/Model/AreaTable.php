<?php
namespace World\Model;

use Zend\Db\TableGateway\TableGateway;

class AreaTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        
        $adapter = $this->tableGateway->getAdapter();
        
        $sql = "SELECT area.id, area.name, area.city_id, city.name AS city_name, country.name AS country_name, country.abbr AS country_abbr ";
        $sql .= " FROM area LEFT JOIN city ON area.city_id = city.id ";
        $sql .= " LEFT JOIN country ON city.country_id = country.id ORDER BY city.country_id, area.city_id";

        $stmt = $adapter->query($sql);
        $results = $stmt->execute();
        
        return $results;

    }

    public function getArea($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveArea(Area $area)
    {
        $data = array(
            'city_id' => $area->city_id,
            'name' => $area->name,
        );

        $id = (int)$area->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getArea($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteArea($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}