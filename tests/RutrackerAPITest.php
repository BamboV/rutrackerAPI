<?php

namespace VovanSoft\RutrackerAPI\Tests;

use PHPUnit_Framework_TestCase;
use VovanSoft\RutrackerAPI\Entities\Options\SearchOptions;
use VovanSoft\RutrackerAPI\Entities\Options\SortEntity;
use VovanSoft\RutrackerAPI\GuzzleSender;
use VovanSoft\RutrackerAPI\Parsers\SymfonyParser;
use VovanSoft\RutrackerAPI\RutrackerAPI;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerAPITest extends PHPUnit_Framework_TestCase
{
    private function getRutrackerAPI()
    {
        $rutrackerAPI = new RutrackerAPI('Y6uBaJIKaCCCP', 'cccp081293', new GuzzleSender(), new SymfonyParser(),$this->getCookies());
        $this->saveCookies($rutrackerAPI->getCookies());
        return $rutrackerAPI;
    }

    public function te1stDownloadFile()
    {
        $rutrackerAPI = $this->getRutrackerAPI();
        $fileString = $rutrackerAPI->downloadTorrent(5302168);

        $this->saveInFile($fileString, 'torrent.torrent', 'wb');
    }

    public function testSearch()
    {
        $rutrackerAPI = $this->getRutrackerAPI();
        $options = new SearchOptions('the walking dead');
        $options->setOnlyOpen(true);
        $options->setForumId(2366);
        $options->setUserName('qqss44');
        $options->setSort(new SortEntity('seeds', 'DESC'));
        $searchString = $rutrackerAPI->search($options);
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

    public function tes1tParser()
    {
        $text = fread(fopen('search.html', 'r'), filesize('search.html'));

        $rutrackerTopics = (new SymfonyParser())->parse($text);

        var_dump($rutrackerTopics);
    }

}
