<?php

namespace BamboV\RutrackerAPI\Entities;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerTopic
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var RutrackerForum
     */
    private $forum;

    /**
     * @var string
     */
    private $theme;

    /**
     * @var RutrackerAuthor
     */
    private $author;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $seedersCount;

    /**
     * @var int
     */
    private $leechersCount;

    /**
     * @var int
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }



    /**
     * @return RutrackerForum
     */
    public function getForum(): RutrackerForum
    {
        return $this->forum;
    }

    /**
     * @param RutrackerForum $forum
     *
     * @return $this
     */
    public function setForum(RutrackerForum $forum)
    {
        $this->forum = $forum;
        return $this;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     *
     * @return $this
     */
    public function setTheme(string $theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return RutrackerAuthor
     */
    public function getAuthor(): RutrackerAuthor
    {
        return $this->author;
    }

    /**
     * @param RutrackerAuthor $author
     *
     * @return $this
     */
    public function setAuthor(RutrackerAuthor $author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeedersCount(): int
    {
        return $this->seedersCount;
    }

    /**
     * @param int $seedersCount
     *
     * @return $this
     */
    public function setSeedersCount(int $seedersCount)
    {
        $this->seedersCount = $seedersCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getLeechersCount(): int
    {
        return $this->leechersCount;
    }

    /**
     * @param int $leechersCount
     *
     * @return $this
     */
    public function setLeechersCount(int $leechersCount)
    {
        $this->leechersCount = $leechersCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(int $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
