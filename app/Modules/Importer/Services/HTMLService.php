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
        
        $htmlDataPart1 = $this->getElementsByClassName('rgRow', 'tr');
        $htmlDataPart2 = $this->getElementsByClassName('rgAltRow', 'tr');
        $rawData = array_merge($htmlDataPart1, $htmlDataPart2);
        return $rawData;
    }
    /**
     * Sourced from:
     * https://stackoverflow.com/a/52462848
     */
    private function getElementsByClassName($ClassName, $tagName=null) {
        if($tagName){
            $Elements = $this->dom->getElementsByTagName($tagName);
        }else {
            $Elements = $this->dom->getElementsByTagName("*");
        }
        $Matched = array();
        for($i=0;$i<$Elements->length;$i++) {
            if($Elements->item($i)->attributes->getNamedItem('class')){
                if($Elements->item($i)->attributes->getNamedItem('class')->nodeValue == $ClassName) {
                    $Matched[]=$Elements->item($i);
                }
            }
        }
        return $Matched;
    }

}
