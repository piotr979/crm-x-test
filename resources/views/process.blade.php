<?php

namespace App\Modules\Importer\Services;

use App\Modules\Importer\Repositories\ImporterRepository;
use Illuminate\Container\Container;
use DomDocument;

class DOMService
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var ImporterRepository
     */
    protected $importer;

    /**
     * @var dom 
     */
    protected $dom;
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
    public function loadDoc($buffer)
    {
        // if there are errors (like double id's) ignore them
        $this->doc->loadHTML($buffer, LIBXML_NOERROR);
    }
    public function getItemById(string $item): string
    {
        $domElement = $this->doc->getElementById($item);
        return $domElement->textContent;
    }

}
