<?php

namespace Cocoders\UseCase;

trait ResponderAwareBehavior
{
    /**
     * @var Responder[]
     */
    private $responders = [];

    public function addResponder(Responder $responder)
    {
        $this->responders[] = $responder;
    }
}