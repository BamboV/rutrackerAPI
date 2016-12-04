<?php

namespace BamboV\RutrackerAPI\Filters;

use BamboV\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractRutrackerTopicFilter
{
    /**
     * @param RutrackerTopic $topic
     *
     * @return bool
     */
    public abstract function check(RutrackerTopic $topic):bool;
}
