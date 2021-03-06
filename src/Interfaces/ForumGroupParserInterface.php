<?php

namespace BamboV\RutrackerAPI\Interfaces;

use BamboV\RutrackerAPI\Entities\RutrackerForumGroup;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface ForumGroupParserInterface
{
    /**
     * @param string $html
     *
     * @return array
     */
    public function parse(string $html):array;
}
