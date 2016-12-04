<?php

namespace BamboV\RutrackerAPI\Filters;

use BamboV\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FilterList extends AbstractRutrackerTopicFilter
{
    /**
     * @var AbstractRutrackerTopicFilter[]
     */
    protected $filters = [];

    /**
     * @param RutrackerTopic $topic
     *
     * @return bool
     */
    public function check(RutrackerTopic $topic): bool
    {
        foreach ($this->filters as $filter) {
            if(!$filter->check($topic)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param AbstractRutrackerTopicFilter $filter
     */
    public function add(AbstractRutrackerTopicFilter $filter)
    {
        $this->filters[] = $filter;
    }
}
