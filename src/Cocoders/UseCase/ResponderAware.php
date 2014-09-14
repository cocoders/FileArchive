<?php

namespace Cocoders\UseCase;

interface ResponderAware
{
    /**
     * @return void
     */
    public function addResponder(Responder $responder);
}
