<?php

namespace VovanSoft\RutrackerAPI\Parsers;

use Symfony\Component\DomCrawler\Crawler;
use VovanSoft\RutrackerAPI\Entities\RutrackerForum;
use VovanSoft\RutrackerAPI\Entities\RutrackerForumGroup;
use VovanSoft\RutrackerAPI\Interfaces\ForumGroupParserInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class SymfonyForumGroupParser implements ForumGroupParserInterface
{

    /**
     * @param string $html
     *
     * @return array| RutrackerForumGroup[]
     */
    public function parse(string $html): array
    {
        $crawler = new Crawler($html);

        $forumGroups = [];
        /** @var RutrackerForum $forumGroup */
        $forumGroup = null;
        $forums = [];

        $crawler->filter('optgroup > option')->each(function($item) use (&$forumGroup, &$forumGroups, &$forums){

            /** @var Crawler $item */
            if(is_null($item->attr('class'))){
                $forums[] = new RutrackerForum($item->attr('value'), trim($item->text(),' |-'));
            } else {

                if(!is_null($forumGroup)) {
                    $forumGroups[] = new RutrackerForumGroup($forumGroup->getId(), $forumGroup->getTitle(), $forums);
                    $forums = [];
                }

                $forumGroup = new RutrackerForum($item->attr('value'), $item->text());
            }
        });
        $forumGroups[] = new RutrackerForumGroup($forumGroup->getId(), $forumGroup->getTitle(), $forums);

        return $forumGroups;
    }
}
