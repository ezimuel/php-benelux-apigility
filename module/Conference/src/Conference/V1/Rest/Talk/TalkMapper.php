<?php
namespace Conference\V1\Rest\Talk;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Paginator;

class TalkMapper
{
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $resultSet = new HydratingResultSet();
        $resultSet->setObjectPrototype(new TalkEntity());
        $this->table = new TableGateway('talks', $adapter, null, $resultSet);
    }

    public function getAllTalk()
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->table);
        $paginator = new Paginator($dbTableGatewayAdapter);
        return $paginator;
    }

    public function getTalk($talkId)
    {
        $rowset = $this->table->select(array('id' => $talkId));
        $talk = $rowset->current();
        return $talk;
    }

    public function addTalk($talk)
    {
        $data = $this->getArray($talk);
        try {
          $this->table->insert($data);
        } catch (\Exception $e) {
          return false;
        }
        $rowset = $this->table->select(array('id' => $this->table->lastInsertValue));
        return $rowset->current();
    }

    public function updateTalk($id, $talk)
    {
      $data = $this->getArray($talk);
      try {
        $this->table->update($data, array('id' => $id));
      } catch (\Exception $e) {
        return false;
      }
      $rowset = $this->table->select(array('id' => $id));
      return $rowset->current();
    }

    public function deleteTalk($id)
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
      if (isset($object->title)) {
        $data['title'] = $object->title;
      }
      if (isset($object->abstract)) {
        $data['abstract'] = $object->abstract;
      }
      if (isset($object->schedule)) {
        $data['day'] = $object->day;
      }
      if (isset($object->start_time)) {
        $data['start_time'] = $object->start_time;
      }
      if (isset($object->end_time)) {
        $data['end_time'] = $object->end_time;
      }
      return $data;
    }
}
