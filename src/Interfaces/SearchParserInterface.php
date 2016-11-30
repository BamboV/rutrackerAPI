<?php

namespace VovanSoft\RutrackerAPI\Interfaces;

use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface SearchParserInterface
{
    /**
     * @param string $html
     *
     * @return RutrackerTopic[]
     */
    public function parse(string $html): array;
}
