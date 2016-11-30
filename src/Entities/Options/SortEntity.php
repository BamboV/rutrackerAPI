<?php

namespace VovanSoft\RutrackerAPI\Entities\Options;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class SortEntity
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $direction;

    public function __construct(string $field, string $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}
