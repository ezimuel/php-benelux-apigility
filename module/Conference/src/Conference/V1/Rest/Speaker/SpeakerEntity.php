<?php
namespace Conference\V1\Rest\Speaker;

class SpeakerEntity
{
    public $id;
    public $name;
    public $title;
    public $company;
    public $url;
    public $twitter;

    public function getArrayCopy()
    {
      return array(
        'id'      => $this->id,
        'name'    => $this->name,
        'title'   => $this->title,
        'company' => $this->company,
        'url'     => $this->url,
        'twitter' => $this->twitter
      );
    }

    public function exchangeArray(array $array)
    {
      $this->id      = $array['id'];
      $this->name    = $array['name'];
      $this->title   = $array['title'];
      $this->company = $array['company'];
      $this->url     = $array['url'];
      $this->twitter = $array['twitter'];
    }
}
