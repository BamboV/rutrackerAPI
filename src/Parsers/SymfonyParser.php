<?php

namespace BamboV\RutrackerAPI\Parsers;

use Symfony\Component\DomCrawler\Crawler;
use BamboV\RutrackerAPI\Entities\RutrackerAuthor;
use BamboV\RutrackerAPI\Entities\RutrackerForum;
use BamboV\RutrackerAPI\Entities\RutrackerTopic;
use BamboV\RutrackerAPI\Interfaces\SearchParserInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class SymfonyParser implements SearchParserInterface
{
    public function parse(string $html): array
    {
        $crawler = new Crawler($html);

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

        return $rutrackerTopics;
    }

}
