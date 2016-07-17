<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use App\Model\{NewsReaderItem, NewsReaderItemList};

/**
 *  This is a simple NewsReader implementation that other NewsReader can inherit from.
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
abstract class AbstractNewsReader implements NewsReaderInterface
{
    /**
     * Log the request
     * 
     * @var LoggerInterface $logger
     */
    protected $logger;
    
    /**
     * array of the news feed declared in application settings
     * 
     * @ var array
     */
    protected $settings;
    
    /**
     * Get the all the  possible endpoints
     * 
     * @var array $available_feeds
     * @var array $settings 
     */
    public function find(array $available_feeds = null, string $feed = null ): array
    {
        $results = [];
        if( $available_feeds == null ){
            $available_feeds = $this->settings;
        }

        
        if( $feed !== null && ! isset( $available_feeds[$feed] ) ){
            $this->manageError('The feed '.$feed.' is undefined');
        }
        
        if( $feed !== null ){
            $results[$feed] = $this->formatFeed($this->request($feed, $available_feeds[$feed]));
        } else {          
            foreach( $available_feeds as $feed_name => $url  ){
                $results[$feed_name] = $this->formatFeed($this->request($feed_name, $available_feeds[$feed_name]));
            }
        }
        
        return $results;
    }
    
    /**
     * Manage request error by logging and throw Exception
     * 
     * @param string $message the error message to log
     * @throws \Exception
     */
    protected function manageError( string $message )
    {
        $this->logger->error($message);
        throw new \Exception($message);
    }
    
     /**
     * Send request to the RSS feed
     * 
     * @ param string feed the feed name
     * @param string $url the uri of the feed to request
     * @return string the feed content
     */
    protected function request( string $feed, string $url ) : string
    {
        
        // log the request to send
        $this->logger->info(" Send request to News Feed [" .$url."]");
                
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
        $body = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        
        if( $body === null ){
            $this->manageError("Request Error");
        }
        
        if( $info['http_code'] > 400){
            $this->manageError("Error for feed '".$feed."' with status code response: ". $info['http_code'] );
        }
        
        return $body;

    }
    
    /**
     * get all the news feed available filter by a list of preferences
     * Only feeds in the $preferences parameters are returned
     * If no preferences exists (null), all the feeds are returned 
     * 
     * @param array $preferences 
     * @return array 
     */
    public function getAvailableFeedsFilterByPreferences( array $preferences = null ): array
    {
        $feeds = [];
        
        if( $preferences == null ){
            $feeds = $this->settings;
        } else {
           foreach( $this->settings as $feed_name => $url  ){

                if( isset($preferences[$feed_name]) && $preferences[$feed_name]  ){
                    $feeds[$feed_name] = $url;
                }
            }         
        }
        
        return $feeds;
    }
    
    /**
     * Format the feed to an newsReaderListItem
     * 
     * Must be implemented
     */
    protected abstract function formatFeed(string $content): NewsReaderItemList;
}
