<?php
namespace Conference\V1\Rest\Speaker;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Paginator;


class SpeakerMapper
{
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $resultSet = new HydratingResultSet();
        $resultSet->setObjectPrototype(new SpeakerEntity());
        $this->table = new TableGateway('speakers', $adapter, null, $resultSet);
    }

    public function getAllSpeaker()
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->table);
        $paginator = new Paginator($dbTableGatewayAdapter);
        return $paginator;
    }

    public function getSpeaker($speakerId)
    {
        $rowset = $this->table->select(array('id' => $speakerId));
        return $rowset->current();
    }

    public function addSpeaker($speaker)
    {
        $data = $this->getArray($speaker);
        try {
          $this->table->insert($data);
        } catch (\Exception $e) {
          return false;
        }
        $rowset = $this->table->select(array('id' => $this->table->lastInsertValue));
        return $rowset->current();
    }

    public function updateSpeaker($id, $speaker)
    {
      $data = $this->getArray($speaker);
      try {
        $this->table->update($data, array('id' => $id));
      } catch (\Exception $e) {
        return false;
      }
      $rowset = $this->table->select(array('id' => $id));
      return $rowset->current();
    }

    public function deleteSpeaker($id)
    {
      try {
        $result = $this->table->delete(array('id' => $id));
      } catch (\Exception $e) {
        return false;
      }
      return ($result > 0);
    }

    protected function getArray($object)
    {
      $data = array();
      if (isset($object->id)) {
        $data['id'] = $object->id;
      }
      if (isset($object->name)) {
        $data['name'] = $object->name;
      }
      if (isset($object->title)) {
        $data['title'] = $object->title;
      }
      if (isset($object->company)) {
        $data['company'] = $object->company;
      }
      if (isset($object->url_company)) {
        $data['url'] = $object->url;
      }
      if (isset($object->twitter)) {
        $data['twitter'] = $object->twitter;
      }
      return $data;
    }
}
