<?php

namespace App\Service;

/**
 * Describe a NewsReaderService instance
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
interface NewsReaderInterface 
{
 
    /**
     * Find all the items of a news. If no feed are passed in parameters, all the feeds are requested. 
     * 
     * @param string $feed the name of the feed to read
     * @return array depend of the implementation
     */
    public function find( string $feed = null ): array;
    
    
}
