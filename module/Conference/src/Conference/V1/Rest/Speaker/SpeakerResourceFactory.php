<?php
namespace Conference\V1\Rest\Speaker;

class SpeakerResourceFactory
{
    public function __invoke($services)
    {
        $mapper = new SpeakerMapper($services->get("conference"));
        return new SpeakerResource($mapper);
    }
}
