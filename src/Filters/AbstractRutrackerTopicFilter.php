<?php

namespace VovanSoft\RutrackerAPI\Filters;

use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;

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
