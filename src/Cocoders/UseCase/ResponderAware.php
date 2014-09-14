<?php

namespace Cocoders\UseCase;

interface ResponderAware
{
    public function addResponder(Responder $responder);
}
