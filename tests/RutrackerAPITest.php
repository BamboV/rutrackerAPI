<?php

namespace BamboV\RutrackerAPI\Tests;

use BamboV\RutrackerAPI\Tests\Mock\MockSender;
use PHPUnit_Framework_TestCase;
use BamboV\RutrackerAPI\Entities\Options\SearchOptions;
use BamboV\RutrackerAPI\Entities\Options\SortEntity;
use BamboV\RutrackerAPI\Parsers\SymfonyForumGroupParser;
use BamboV\RutrackerAPI\Parsers\SymfonyParser;
use BamboV\RutrackerAPI\RutrackerAPI;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerAPITest extends PHPUnit_Framework_TestCase
{
    private function getRutrackerAPI()
    {
        $mockSender = new MockSender();
        $rutrackerAPI = new RutrackerAPI($mockSender->getLogin(), $mockSender->getPassword(), $mockSender, new SymfonyParser(), new SymfonyForumGroupParser());

        return $rutrackerAPI;
    }

    public function testDownloadFile()
    {
        $rutrackerAPI = $this->getRutrackerAPI();
        $fileString = $rutrackerAPI->downloadTorrent(5302168);

        $text = fread(fopen('tests/Files/torrent.torrent', 'r'), filesize('tests/Files/torrent.torrent'));
        $this->assertEquals($text, $fileString);
    }

    public function testSearch()
    {
        $rutrackerAPI = $this->getRutrackerAPI();
        $options = new SearchOptions('the walking dead');
        $options->setOnlyOpen(true);
        $options->setForumId(2366);
        $options->setUserName('qqss44');
        $options->setSort(new SortEntity('seeds', 'DESC'));
        $resp = $rutrackerAPI->search($options);

        $this->assertEquals(50, count($resp));

        $this->assertEquals(
            'Ходячие мертвецы / The Walking Dead / Сезон: 7 / Серии: 1-6 из 16 (Эрнест Р. Дикерсон, Грег Никотеро, Гай Ферленд) [2016, США, Ужасы, триллер, драма, WEBRip 1080p] 2xMVO (LostFilm | FOX HD) + Original + Subs (Rus, Eng)',
            $resp[0]->getTheme()
        );

    }

    public function testGetForums()
    {
        $rutrackerAPI = $this->getRutrackerAPI();

        $groups = $rutrackerAPI->getAllForums();

        $this->assertNotEmpty($groups);
    }

}
