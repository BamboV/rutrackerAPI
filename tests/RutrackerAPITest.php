<?php

namespace VovanSoft\RutrackerAPI\Tests;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DomCrawler\Crawler;
use VovanSoft\RutrackerAPI\Entities\RutrackerAuthor;
use VovanSoft\RutrackerAPI\Entities\RutrackerForum;
use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;
use VovanSoft\RutrackerAPI\GuzzleSender;
use VovanSoft\RutrackerAPI\RutrackerAPI;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerAPITest extends PHPUnit_Framework_TestCase
{
    private function getRutrackerAPI()
    {
        $rutrackerAPI = new RutrackerAPI('Y6uBaJIKaCCCP', 'cccp081293', new GuzzleSender(), $this->getCookies());
        $this->saveCookies($rutrackerAPI->getCookies());
        return $rutrackerAPI;
    }

    public function te1stDownloadFile()
    {
        $rutrackerAPI = $this->getRutrackerAPI();
        $fileString = $rutrackerAPI->downloadTorrent(5302168);

        $this->saveInFile($fileString, 'torrent.torrent', 'wb');
    }

    public function tes1tSearch()
    {
        $rutrackerAPI = $this->getRutrackerAPI();
        $searchString = $rutrackerAPI->search('the walking dead');

        $this->saveInFile($searchString, 'search.html');

    }

    private function saveCookies(array $cookies)
    {
        $c = '';
        foreach($cookies as $cookie) {
            $c.=$cookie;
        }

        $this->saveInFile($c, 'cookies.txt');
    }

    /**
     * @return array
     */
    private function getCookies(): array
    {
        try {
            return explode("\n", fread(fopen('cookies.txt', 'r'), filesize('cookies.txt')));
        } catch(\Exception $ex) {
            return [];
        }
    }

    private function saveInFile(string $data, string $file, string $mode = 'w')
    {
        fwrite(fopen($file, $mode),$data);
    }

    public function testParser()
    {
        $text = fread(fopen('search.html', 'r'), filesize('search.html'));

        $crawler = new Crawler($text);

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

        var_dump($rutrackerTopics[0]);
    }
}
