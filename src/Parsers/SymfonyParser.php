<?php

namespace VovanSoft\RutrackerAPI\Parsers;

use Symfony\Component\DomCrawler\Crawler;
use VovanSoft\RutrackerAPI\Entities\RutrackerAuthor;
use VovanSoft\RutrackerAPI\Entities\RutrackerForum;
use VovanSoft\RutrackerAPI\Entities\RutrackerTopic;
use VovanSoft\RutrackerAPI\Interfaces\SearchParserInterface;

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
