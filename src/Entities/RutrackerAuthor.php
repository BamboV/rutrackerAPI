<?php

namespace VovanSoft\RutrackerAPI\Entities;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerAuthor
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $userName;

    /**
     * RutrackerAuthor constructor.
     *
     * @param int $id
     * @param string $userName
     */
    public function __construct(int $id, string $userName)
    {
        $this->id= $id;
        $this->userName = $userName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }
}
