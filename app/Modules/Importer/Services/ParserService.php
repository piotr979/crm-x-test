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
    public function parseRawData(array $rawData)
    {
        
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
   

}
