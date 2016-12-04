<?php

namespace BamboV\RutrackerAPI\Tests\Mock;

use BamboV\RutrackerAPI\Interfaces\SenderInterface;
use BamboV\RutrackerAPI\Request;
use BamboV\RutrackerAPI\Response;
use BamboV\RutrackerAPI\RutrackerAPI;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class MockSender implements SenderInterface
{
    private $login;
    private $password;
    private $cookie;

    public function __construct()
    {
        $this->login = 'login'.random_int(1,100000);
        $this->password = 'pas'.random_int(1,100000);
        $this->cookie = 'cook'.random_int(1,100000);
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function send(Request $request, bool $allowRedirect = false): Response
    {

        if ($request->getUrl() == RutrackerAPI::RUTRACKER_LOGIN_URL) {
            return $this->login($request);
        }
        if (explode('=', $request->getUrl())[0].'=' == RutrackerAPI::RUTRACKER_DOWNLOAD_TORRENT_URL) {
            return $this->getTorrent($request);
        }
        if (explode('=', $request->getUrl())[0].'=' == RutrackerAPI::RUTRACKER_SEARCH_URL){
            return $this->getSearch($request);
        }

        throw new \RuntimeException('Wrong url');
    }
    private function login(Request $request)
    {
        if (
            $request->getData()['login_username'] == $this->login &&
            $request->getData()['login_password'] == $this->getPassword() &&
            $request->getData()['login'] == RutrackerAPI::RUTRACKER_LOGIN_CONST
        ) {
            return new Response(304, '', ['bb_data=' . $this->cookie . '; expires=Sat, 28-Nov-2026 18:52:31 GMT; Max-Age=315360000; path=/forum/; domain=.rutracker.org; httponly']);
        }
        return new Response(304, '', []);
    }

    private function checkAuthorization(Request $request) {
        return $request->getCookies()[0] == 'bb_data='.$this->cookie;
    }

    private function getTorrent(Request $request) {
        if(!$this->checkAuthorization($request)){
            return new Response(304, '', []);
        }
        $text = fread(fopen('tests/Files/torrent.torrent', 'r'), filesize('tests/Files/torrent.torrent'));

        return new Response(200, $text, []);
    }

    private function getSearch(Request $request)
    {
        if(!$this->checkAuthorization($request)){
            return new Response(304, '', []);
        }
        $text = fread(fopen('tests/Files/search.html', 'r'), filesize('tests/Files/search.html'));
        return new Response(200, $text, []);
    }

}
