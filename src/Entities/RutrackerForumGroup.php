<?php

namespace BamboV\RutrackerAPI\Entities;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerForumGroup extends RutrackerForum
{
    /**
     * @var RutrackerForum[]
     */
    private $subForums;

    /**
     * RutrackerForumGroup constructor.
     *
     * @param int $id
     * @param string $title
     * @param array $subForums
     */
    public function __construct(int $id, string $title, array $subForums)
    {
        parent::__construct($id, $title);
        $this->subForums = $subForums;
    }

    /**
     * @return array|RutrackerForum[]
     */
    public function getSubForums()
    {
        return $this->subForums;
    }
}
