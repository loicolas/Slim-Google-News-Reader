<?php

namespace App\Model;

/**
 * Describe the NewsReaderItem instance used for all Feed item
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class NewsReaderItem 
{
    
    /**
     * THe title of the item
     * 
     * @var string 
     */
    protected $title;
    
    /**
     * the url of the item
     * 
     * @var string 
     */
    protected $url;
    
    
    /**
     * the summary of the item
     * 
     * @var string
     */
    protected $summary;
   
    /**
     * the date of the item
     * 
     * @var \DateTime 
     */
    protected $date;
    
    /**
     * Get the title 
     * 
     * @return string
     */
    public function getTitle(): string 
    {
        return $this->title;
    }

    /**
     * Set the title
     * 
     * @param string $title
     * @return NewsReaderItem
     */
    public function setTitle(string $title): NewsReaderItem
    {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Get the url 
     * 
     * @return string
     */
    public function getUrl(): string 
    {
        return $this->url;
    }

    /**
     * Set the url
     * 
     * @param string $title
     * @return NewsReaderItem
     */
    public function setUrl(string $url): NewsReaderItem 
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get the summary
     * 
     * @return string
     */
    public function getSummary(): string  
    {
        return $this->summary;
    }

    /**
     * Set the summary
     * 
     * @return NewsReaderItem
     */
    public function setSummary(string $summary): NewsReaderItem 
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * Get the date 
     * 
     * @return \DateTime
     */
    public function getDate(): \DateTime 
    {
        return $this->date;
    }

    /**
     * Set the date 
     * 
     * @return NewsReaderItem
     */
    public function setDate(\DateTime $date): NewsReaderItem
    {
        $this->date = $date;
        return $this;
    }




    
}
