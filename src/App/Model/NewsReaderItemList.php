<?php

namespace App\Model;

/**
 * Describe the NewsReaderItemList instance used for all Feed item list
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class NewsReaderItemList implements \Iterator
{
    
    /**
     * THe title of the list item
     * 
     * @var string 
     */
    protected $title;
    
    /**
     * the $description of the list item
     * 
     * @var string
     */
    protected $description;
    
    /**
     * the list of items
     * 
     * @var array
     */
    protected $items;
    
    /**
     * the position of the pointer
     * 
     * @var int
     */
    protected $position;
    
   
    public function __construct() 
    {
        $this->items   = array();
        $this->position = 0;
    }
    
    
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
     * @return NewsReaderItemList
     */
    public function setTitle(string $title): NewsReaderItemList
    {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Get the description 
     * 
     * @return string
     */
    public function getDescription(): string 
    {
        return $this->description;
    }

    /**
     * Set the description
     * 
     * @param string $description
     * @return NewsReaderItemList
     */
    public function setDescription(string $description): NewsReaderItemList 
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the items 
     * 
     * @return array
     */
    public function getItems(): array 
    {
        return $this->items;
    }

    /**
     * Set the items
     * 
     * @param array $items
     * @return NewsReaderItemList
     */
    public function setItems(array $items): NewsReaderItemList
   {
        $this->items = $items;
        return $this;
    }
    
    public function addItem( NewsReaderItem  $item ): NewsReaderItemList
    {
        $this->items[] = $item;
        return $this;
    }


    public function rewind() 
    {
        $this->position = 0;
    }

    public function current(): NewsReaderItem
    {
        return $this->items[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    /**
     * 
     */
    public function next() 
    {
        ++$this->position;
    }

    /**
     * check if the position of hte pointer is valid
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    
}
