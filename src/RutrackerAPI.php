<?php

namespace VovanSoft\RutrackerAPI;

use DateTime;
use Sunra\PhpSimple\HtmlDomParser;
use Symfony\Component\DomCrawler\Crawler;
use VovanSoft\RutrackerAPI\Entities\RutrackerAuthor;
use VovanSoft\RutrackerAPI\Entities\RutrackerForum;
use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;
use VovanSoft\RutrackerAPI\Filters\AbstractRutrackerTopicFilter;
use VovanSoft\RutrackerAPI\Interfaces\SenderInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerAPI
{
    /**
     * @const string
     */
    const RUTRACKER_URL = 'http://rutracker.org.3s3s.org';

    const RUTRACKER_SEARCH_URL = 'http://rutracker.org.3s3s.org/forum/tracker.php?nm=';

    const RUTRACKER_DOWNLOAD_TORRENT_URL = 'http://dl.rutracker.org.3s3s.org/forum/dl.php?t=';

    /**
     * @const string
     */
    const RUTRACKER_LOGIN_URL = 'http://login.rutracker.org.3s3s.org/forum/login.php';

    /**
     * @const string
     */
    const RUTRACKER_LOGIN_CONST = "%C2%F5%EE%E4";

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var SenderInterface
     */
    private $sender;

    /**
     * @var array
     */
    private $cookies=[];

    public function __construct(string $login, string $password, SenderInterface $sender, array $cookies = null)
    {
        $this->login = $login;
        $this->password = $password;
        $this->sender = $sender;

        if($cookies) {
            $this->setCookies($cookies);
        }

        if(!$this->cookies) {
            $this->login();
        }
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    private function send(Request $request) : Response
    {
        $request->setCookies( array_map(function($item){
            return explode(';', $item)[0];
        },$this->getCookies()));
        return $this->sender->send($request);
    }

    private function login()
    {
        $request = new Request(self::RUTRACKER_LOGIN_URL, 'POST', [
            'login_username' => $this->login,
            'login_password' => $this->password,
            'login' => self::RUTRACKER_LOGIN_CONST
        ]);

        $resp = $this->send($request);

        $this->setCookies($resp->getCookies());
    }

    public function search($name, AbstractRutrackerTopicFilter $filter = null)
    {
        $request = new Request(self::RUTRACKER_SEARCH_URL.str_replace(' ', '%20', $name));

        $resp = $this->send($request);

        $crawler = new Crawler($resp->getBody());

        $rutrackerTopics = [];

        $crawler->filter('.hl-tr')->each(function($item)use (&$rutrackerTopics){
            /** @var Crawler $item */

            $themeLink = $item->filter('.t-title > a');
            $authorLink = $item->filter('.u-name > a');
            $forumLink = $item->filter('.f-name > a');
            $rutrackerTopic = (new RutrackerTopic())
                ->setForum(new RutrackerForum(explode('&', explode('f=',$forumLink->attr('href'))[1])[0], $forumLink->text()))
                ->setId($themeLink->attr('data-topic_id'))
                ->setTheme($themeLink->text())
                ->setAuthor(new RutrackerAuthor(explode('=',$authorLink->attr('href'))[1], $authorLink->text()))
                ->setSize($item->filter('.tor-size > u')->text())
                ->setSeedersCount($item->filter('td')->getNode(6)->getElementsByTagName('u')->item(0)->textContent)
                ->setLeechersCount($item->filter('.leechmed > b')->text())
                ->setCreatedAt($item->filter('td')->getNode(9)->getElementsByTagName('u')->item(0)->textContent);

            $rutrackerTopics[] = $rutrackerTopic;
        });

        if($filter){
            $rutrackerTopics = array_filter($rutrackerTopics, function($item)use($filter){
                return $filter->check($item);
            });
        }

        return $rutrackerTopics;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function downloadTorrent(int $id)
    {
        $request = new Request(self::RUTRACKER_DOWNLOAD_TORRENT_URL.$id);

        $resp = $this->send($request);

        return $resp->getBody();
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    private function setCookies(array $cookies) {
        $this->cookies = array_filter($cookies, function($item){
            $matches = [];
            preg_match("/expires=([^;#]*)/", $item, $matches);
            return
                count($matches) == 2 &&
                    (new DateTime($matches[1]))->getTimestamp() > time();
        });
    }


}
