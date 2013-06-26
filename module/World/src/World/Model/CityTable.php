<?php
namespace World\Model;

use Zend\Db\TableGateway\TableGateway;

class CityTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        
        $adapter = $this->tableGateway->getAdapter();
        
        $sql = "SELECT city.id, city.name, city.country_id, country.abbr AS country_abbr, country.name AS country_name ";
        $sql .= " FROM city LEFT JOIN country ON city.country_id = country.id ORDER BY city.country_id";

        $stmt = $adapter->query($sql);
        $results = $stmt->execute();
        
        return $results;

    }

    public function getCity($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCity(City $city)
    {
        $data = array(
            'country_id' => $city->country_id,
            'name' => $city->name,
        );

        $id = (int)$city->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCity($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCity($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}