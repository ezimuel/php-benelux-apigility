<?php
namespace Conference\V1\Rest\Speaker;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;
use Conference\V1\Rest\Talk\TalkEntity;
use Conference\V1\Rest\Talk\TalkCollection;
use Zend\Stdlib\Hydrator\ArraySerializable;


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
        $speaker = $rowset->current();

        // get the spakers from the talks_speakers table
        $sql = new Sql($this->table->adapter);
        $select = $sql->select();
        $select->from('talks')
               ->join('talks_speakers', 'talks_speakers.talk_id = talks.id')
               ->where(array('talks_speakers.speaker_id' => $speakerId));

        // build the SpeakerCollection based on $select
        $resultSet = new HydratingResultSet(
            new ArraySerializable(),
            new TalkEntity()
        );
        $paginatorAdapter = new DbSelect($select, $this->table->adapter, $resultSet);
        $speaker->talks = new TalkCollection($paginatorAdapter);

        return $speaker;
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
      if (isset($object->url)) {
        $data['url'] = $object->url;
      }
      if (isset($object->twitter)) {
        $data['twitter'] = $object->twitter;
      }
      return $data;
    }
}
