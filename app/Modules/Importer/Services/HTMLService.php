<?php

namespace App\Modules\Importer\Services;

use App\Modules\Importer\Repositories\ImporterRepository;
use Illuminate\Container\Container;
use DomDocument;

class HTMLService
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var $dom
     */
    protected $dom;
    /**
     * @var ImporterRepository
     */
    protected $importer;

    /**
     * Initialize class parameters
     *
     * @param Container $app
     * @param ImporterRepository $importer
     */
    public function __construct(Container $app, ImporterRepository $importer)
    {
        $this->app = $app;
        $this->importer = $importer;
        $this->dom = new DomDocument;
    }
    public function extractData($html)
    {
        // silencing DOMDocument errors
        // due to poor html source quality
        @$this->dom->loadHTML($html);
        
        $matched1 = $this->getElementsByClassName('rgRow', 'tr');
        $matched2 = $this->getElementsByClassName('rgAltRow', 'tr');

        $entityId = [];
       
        $tickets = $this->getTickets($html);
        foreach($tickets as $key => $value) {
            if (stripos($value, 'Ticket.aspx?entityid=') !== false) {
                $entityId[$key] = trim($value, 'Ticket.aspx?entityid=');
            }
        }
        return [array_merge($matched1, $matched2),
                    $entityId];
               

   }

    public function getElementByName($tag, $value)
    {
      //  return $this->dom->getNamedItem('title');
        
    }
    /**
     * Sourced from:
     * https://stackoverflow.com/a/52462848
     */
    private function getElementsByClassName($className, $tagName=null) {
        if($tagName){
            $Elements = $this->dom->getElementsByTagName($tagName);
        }else {
            $Elements = $this->dom->getElementsByTagName("*");
        }
        $matched = array();
        for($i=0;$i<$Elements->length;$i++) {
            if($Elements->item($i)->attributes->getNamedItem('class')){
                if($Elements->item($i)->attributes->getNamedItem('class')->nodeValue == $className) {
                    $matched[]=$Elements->item($i);
                } 
            }
            if($Elements->item($i)->attributes->getNamedItem('title')){
                var_dump($Elements->item($i));
            }
        }
       
        return $matched;
    }
    public function getTickets($html) 
    {
        // tickets are extractions from href attr
        // combined with the rest of results will be
        // returned for parsing.
        $tickets = [];
        foreach($this->dom->getElementsByTagName("a") as $element) {
            if ($element->getAttribute('href')) {
                $tickets[($element->textContent)] =
                $element->getAttribute('href') ;
            }
        }
        return $tickets;
    }
}
