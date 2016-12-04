<?php

namespace BamboV\RutrackerAPI\Filters;

use BamboV\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class AuthorIdFilter extends AbstractRutrackerTopicFilter
{
    /**
     * @var int
     */
    private $authorId;

    /**
     * AuthorIdFilter constructor.
     *
     * @param int $authorId
     */
    public function __construct(int $authorId)
    {
        $this->authorId = $authorId;
    }

    public function check(RutrackerTopic $topic): bool
    {
        return $topic->getAuthor()->getId() == $this->authorId;
    }

}
