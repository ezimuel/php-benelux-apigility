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
    public $talks;

    public function getArrayCopy()
    {
      return array(
        'id'      => $this->id,
        'name'    => $this->name,
        'title'   => $this->title,
        'company' => $this->company,
        'url'     => $this->url_company,
        'twitter' => $this->twitter,
        'talks'   => $this->talks
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
      
      // Talks is only available when loading a single item. Not on overview.
      if (isset($array['talks'])) {
        $this->talks   = $array['talks'];
      }
    }
}
