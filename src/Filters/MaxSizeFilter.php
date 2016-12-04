<?php

namespace BamboV\RutrackerAPI\Filters;

use BamboV\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class MaxSizeFilter extends AbstractRutrackerTopicFilter
{
    /**
     * @var int
     */
    private $maxSize;

    /**
     * MaxSizeFilter constructor.
     *
     * @param int $maxSize
     */
    public function __construct(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * @param RutrackerTopic $topic
     *
     * @return bool
     */
    public function check(RutrackerTopic $topic): bool
    {
        return $topic->getSize() <= $this->maxSize;
    }

}