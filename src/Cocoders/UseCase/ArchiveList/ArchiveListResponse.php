<?php

namespace Cocoders\UseCase\ArchiveList;

class ArchiveListResponse
{
    public $items;

    /**
     * @param ArchiveListItem[] $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }
} 