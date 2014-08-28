<?php

namespace Cocoders\Archive;

class InMemoryArchive implements Archive
{
    /**
     * @var String
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
