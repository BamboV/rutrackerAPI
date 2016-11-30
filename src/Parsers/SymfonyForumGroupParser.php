<?php

namespace VovanSoft\RutrackerAPI\Parsers;

use Symfony\Component\DomCrawler\Crawler;
use VovanSoft\RutrackerAPI\Interfaces\ForumGroupParserInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class SymfonyForumGroupParser implements ForumGroupParserInterface
{

    public function parse(string $html): array
    {
        $crawler = new Crawler($html);

        $forumGroups = [];

//        $crawler->filter('select#fs-main > op')
    }
}
