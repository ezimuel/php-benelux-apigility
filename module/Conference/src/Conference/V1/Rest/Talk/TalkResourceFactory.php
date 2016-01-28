<?php
namespace Conference\V1\Rest\Talk;

class TalkResourceFactory
{
    public function __invoke($services)
    {
        $mapper = new TalkMapper($services->get("conference"));
        return new TalkResource($mapper);
    }
}
