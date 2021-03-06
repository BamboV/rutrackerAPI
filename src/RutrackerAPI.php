<?php

namespace BamboV\RutrackerAPI;

use DateTime;
use BamboV\RutrackerAPI\Entities\Options\SearchOptions;
use BamboV\RutrackerAPI\Entities\RutrackerTopic;
use BamboV\RutrackerAPI\Filters\AbstractRutrackerTopicFilter;
use BamboV\RutrackerAPI\Interfaces\ForumGroupParserInterface;
use BamboV\RutrackerAPI\Interfaces\SearchParserInterface;
use BamboV\RutrackerAPI\Interfaces\SenderInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerAPI
{
    /**
     * @const string
     */
    const RUTRACKER_URL = 'http://rutracker.org';

    const RUTRACKER_SEARCH_URL = 'http://rutracker.org/forum/tracker.php?nm=';

    const RUTRACKER_DOWNLOAD_TORRENT_URL = 'http://dl.rutracker.org/forum/dl.php?t=';

    /**
     * @const string
     */
    const RUTRACKER_LOGIN_URL = 'http://login.rutracker.org/forum/login.php';

    /**
     * @const string
     */
    const RUTRACKER_LOGIN_CONST = "%C2%F5%EE%E4";

    const FIELDS = [
        'registered' => 1,
        'topic_name' => 2,
        'downloads' => 4,
        'seeds' => 10,
        'leeches' => 11,
        'size' => 7,
        'last_message' => 8
    ];

    const DIRECTIONS = [
        'ASC' => 1,
        'DESC' => 2
    ];

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
    /**
     * @var SearchParserInterface
     */
    private $searchParser;
    /**
     * @var ForumGroupParserInterface
     */
    private $forumGroupParser;

    /**
     * RutrackerAPI constructor.
     *
     * @param string $login
     * @param string $password
     * @param SenderInterface $sender
     * @param SearchParserInterface $searchParser
     * @param ForumGroupParserInterface $forumGroupParser
     * @param array|null $cookies
     */
    public function __construct(
        string $login,
        string $password,
        SenderInterface $sender,
        SearchParserInterface $searchParser,
        ForumGroupParserInterface $forumGroupParser,
        array $cookies = null
    )
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
        $this->searchParser = $searchParser;
        $this->forumGroupParser = $forumGroupParser;
    }

    /**
     * @param Request $request
     * @param bool $allowRedirect
     *
     * @return Response
     */
    private function send(Request $request, bool $allowRedirect = false) : Response
    {
        $request->setCookies( array_map(function($item){
            return explode(';', $item)[0];
        },$this->getCookies()));
        return $this->sender->send($request, $allowRedirect);
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

    /**
     * @param SearchOptions $options
     * @param AbstractRutrackerTopicFilter|null $filter
     *
     * @return array|RutrackerTopic[]
     */
    public function search(SearchOptions $options, AbstractRutrackerTopicFilter $filter = null)
    {
        $resp = $this->send($this->getRequestFromSearchOptions($options), true);

        $rutrackerTopics = $this->searchParser->parse($resp->getBody());

        if($filter){
            $rutrackerTopics = array_filter($rutrackerTopics, function($item)use($filter){
                return $filter->check($item);
            });
        }

        return $rutrackerTopics;
    }

    /**
     * @param SearchOptions $options
     *
     * @return Request
     */
    private function getRequestFromSearchOptions(SearchOptions $options): Request
    {
        $url = self::RUTRACKER_SEARCH_URL.str_replace(' ', '%20', $options->getName());

        $data = [];

        if($options->getOnlyOpen()) {
            $data['oop'] = 1;
        }

        if($options->getUserName()) {
            $data['pn'] = $options->getUserName();
        }

        if($options->getSort()) {
            $data['o'] = self::FIELDS[$options->getSort()->getField()];
            $data['s'] = self::DIRECTIONS[$options->getSort()->getDirection()];
        }

        if($options->getForumId()) {
            $url.='&f='.$options->getForumId();
            if($data) {
                $data['f[]'] = $options->getForumId();
            }
        }

        if(!empty($data)) {
            $data['nm'] = $options->getName();
            return new Request($url, 'POST', $data);
        } else {
            return new Request($url);
        }
    }

    /**
     * @return array
     */
    public function getAllForums()
    {
        $request = new Request(self::RUTRACKER_SEARCH_URL.'1');

        $resp = $this->send($request);

        return $this->forumGroupParser->parse($resp->getBody());

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

    /**
     * @param array $cookies
     */
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
