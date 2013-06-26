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

    /**
     * Grabs all data from `area` table
     */
    public function fetchAll()
    {
        
        $adapter = $this->tableGateway->getAdapter();
        
        $sql = "SELECT area.id, area.name, area.city_id, city.name AS city_name, city.country_id, country.name AS country_name, country.abbr AS country_abbr ";
        $sql .= " FROM area LEFT JOIN city ON area.city_id = city.id ";
        $sql .= " LEFT JOIN country ON city.country_id = country.id ORDER BY city.country_id, area.city_id";

        $stmt = $adapter->query($sql);
        $results = $stmt->execute();
        
        return $results;

    }
    
    /**
     * Grabs all data from `country`, `city`, `area` tables, and formats them in JSON 
     */
    public function fetchAllJSON()
    {
        $worldArray = Array();
        
        $adapter = $this->tableGateway->getAdapter();
        
        $sql = "SELECT id, name FROM country ORDER BY id ASC";
        $stmt = $adapter->query($sql);
        $countries = $stmt->execute();
        
        foreach($countries as $country) {
            $country_id = (int) $country["id"];
            $sql2 = "SELECT id, name FROM city WHERE country_id={$country_id} ORDER BY id ASC";
            $stmt2 = $adapter->query($sql2);
            $cities = $stmt2->execute();
            
            $cityArray = Array();
            
            foreach($cities as $city) {
                $city_id = (int) $city["id"];
                $sql3 = "SELECT id, name FROM area WHERE city_id={$city_id} ORDER BY id ASC";
                $stmt3 = $adapter->query($sql3);
                $areas = $stmt3->execute();
                
                $areaArray = Array();
                
                foreach($areas as $area) {
                    $areaArray[$area['id']] = array("name"=>$area["name"]);
                }
                
                $cityArray[$city['id']] = array("name"=>$city["name"], "areas"=>$areaArray);
            }
            $worldArray[$country['id']] = array("name"=>$country["name"], "cities"=>$cityArray);
        }
        
        return json_encode($worldArray);
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