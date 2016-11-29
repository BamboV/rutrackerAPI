<?php

namespace VovanSoft\RutrackerAPI\Filters;

use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class MinSizeFilter extends AbstractRutrackerTopicFilter
{
    /**
     * @var int
     */
    private $minSize;

    public function __construct(int $minSize)
    {
        $this->minSize = $minSize;
    }

    public function check(RutrackerTopic $topic): bool
    {
        return $topic->getSize() >= $this->minSize;
    }
}
