<?php

namespace VovanSoft\RutrackerAPI\Entities\Options;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class SearchOptions
{
    /**
     * @var string
     */
    private $name; //nm

    /**
     * @var int
     */
    private $forumId; //f[]=

    /**
     * @var SortEntity
     */
    private $sort; //o=10 seeds

    /**
     * @var bool
     */
    private $onlyOpen; //oop=1

    /**
     * @var string
     */
    private $userName; //pn

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getForumId()
    {
        return $this->forumId;
    }

    /**
     * @param int $forumId
     */
    public function setForumId(int $forumId)
    {
        $this->forumId = $forumId;
    }

    /**
     * @return bool
     */
    public function getOnlyOpen()
    {
        return $this->onlyOpen;
    }

    /**
     * @param bool $onlyOpen
     */
    public function setOnlyOpen(bool $onlyOpen)
    {
        $this->onlyOpen = $onlyOpen;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return SortEntity
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param SortEntity $sort
     */
    public function setSort(SortEntity $sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
