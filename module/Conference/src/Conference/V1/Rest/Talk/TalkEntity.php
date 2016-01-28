<?php
namespace Conference\V1\Rest\Talk;

class TalkEntity
{
  public $id;
  public $title;
  public $abstract;
  public $day;
  public $start_time;
  public $end_time;

  public function getArrayCopy()
  {
    return array(
      'id'         => $this->id,
      'title'      => $this->title,
      'abstract'   => $this->abstract,
      'day'        => $this->day,
      'start_time' => $this->start_time,
      'end_time'   => $this->end_time
    );
  }

  public function exchangeArray(array $array)
  {
    $this->id         = $array['id'];
    $this->title      = $array['title'];
    $this->abstract   = $array['abstract'];
    $this->day        = $array['day'];
    $this->start_time = $array['start_time'];
    $this->end_time   = $array['end_time'];
  }
}
