<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Model\{NewsReaderItem, NewsReaderItemList};

/**
 * Describe a RssNewsReaderService instance use to request an RSS feed
 * 
 * @author Loïc Colas <loicolas@gmail.com>
 */
class RssNewsReaderService extends AbstractNewsReader
{
    public function __construct(array $settings, LoggerInterface $logger) 
    {
        $this->logger   = $logger;
        $this->settings = $settings;
    }
    
    protected function formatFeed( string $content ): NewsReaderItemList
    {
        $newsReaderListItem = new NewsReaderItemList();
        $array_content =  (array) simplexml_load_string ( $content);
        
        $newsReaderListItem->setTitle( $array_content['channel']->title)
                            ->setDescription($array_content['channel']->description);
                
        foreach( $array_content['channel']->item as $item ){
            $newsReaderItem = new newsReaderItem();
            $newsReaderItem->setTitle( $item->title )
                            ->setSummary($item->description)
                            ->setUrl($item->link)
                            ->setDate(new \DateTime($item->pubDate));
            $newsReaderListItem->addItem($newsReaderItem);
                    
        }
                
        return $newsReaderListItem;
    }

    
   
     

    
}
