<?php

namespace VovanSoft\RutrackerAPI\Filters;

use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class OneFromListFilter extends FilterList
{

    /**
     * @param RutrackerTopic $topic
     *
     * @return bool
     */
    public function check(RutrackerTopic $topic): bool
    {
        foreach ($this->filters as $filter) {
            if($filter->check($topic)) {
                return true;
            }
        }
        return false;
    }
}
