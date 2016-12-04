<?php

namespace BamboV\RutrackerAPI;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class Response
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $cookies;

    /**
     * Response constructor.
     *
     * @param int $status
     * @param string $body
     * @param string [] $cookies
     */
    public function __construct(int $status, string $body, array $cookies = [])
    {
        $this->status = $status;
        $this->body = $body;
        $this->cookies = $cookies;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }
}
