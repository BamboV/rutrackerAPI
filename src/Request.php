<?php

namespace VovanSoft\RutrackerAPI;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class Request
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string[]
     */
    private $cookies;

    /**
     * Request constructor.
     *
     * @param string $url
     * @param string $method
     * @param array|null $data
     */
    public function __construct(string $url, string $method = 'GET', array $data = null)
    {
        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data?$this->data:[];
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string[]
     */
    public function getCookies(): array
    {
        return $this->cookies?$this->cookies:[];
    }

    /**
     * @param string[] $cookies
     */
    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }


}
