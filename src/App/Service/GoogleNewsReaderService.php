<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

/**
 * Description of GoogleNewsReaderService
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class GoogleNewsReaderService implements GoogleNewsReaderInterface 
{    
    
    /**
     * Log the request
     * 
     * @var LoggerInterface $logger
     */
    private $logger;
    
    /**
     * url of the Google News Reader API endpoint
     * 
     * @var string $endpoint
     */
    private $endpoint;
    
    /**
     * The version of the Google News Api
     * 
     * @var string $version 
     */
    private $version;
    
    /**
     * array of params used to create the request uri
     * 
     * @var array $params 
     */
    private $params;
    
    public function __construct(string $endpoint, string $version, LoggerInterface $logger) 
    {
        $this->logger   = $logger;
        $this->endpoint = $endpoint;
        $this->version  = $version;
        $this->params   = [
            'v' => $version,
            'q' => ''
        ];
    }
    
    
    public function find() 
    {
        $this->request();
    }
    
    
    /**
     * Send request to the Google News API
     */
    protected function request()
    {
        $uri = $this->generateRequestUri($this->endpoint, $this->params);
        
        // log the request to send
        $this->logger->info(" Send request to Google News [" .$uri."]");
                
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
        $body = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        
        var_dump($body);
        
        if( $body === null ){
            $this->manageError("Request Error");
        }
       
        
        $results = json_decode($body, true); 
        if( json_last_error() !== JSON_ERROR_NONE ){
            $this->manageError("JSON decode error: ".  json_last_error_msg());      
        }
        
        if( $results['responseStatus'] > 400){
            $this->manageError("Error with status response: ". $results['responseStatus'] . ' - '.$results['responseDetails'] );
        }

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
     * 
     * @param string $base_uri the base url
     * @param array $params
     * @return string
     */
    protected function generateRequestUri(string $base_uri, array $params)
    {
        $uri = $base_uri;
        $uri .= '?'.http_build_query($params);
        
        return $uri;
    }
    
}
