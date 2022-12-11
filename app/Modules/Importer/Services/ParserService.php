<?php

namespace App\Modules\Importer\Services;

use App\Modules\Importer\Repositories\ImporterRepository;
use Illuminate\Container\Container;

class ParserService
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
     * Initialize class parameters
     *
     * @param Container $app
     * @param ImporterRepository $importer
     */
    public function __construct(Container $app, ImporterRepository $importer)
    {
        $this->app = $app;
        $this->importer = $importer;
    }
    public function parseRawDataAndTickets(array $rawData, array $tickets)
    {
       // basically raw data contains two arrays
       // first part are extracted values
       // second one are anchors with ticket numbers

       // 1. first part will be filtered with regex
       // 2. second with regex too but different pattern

      
        $nodeValues = [];
        $entityId = [];
        foreach($rawData as $node) {
            if (is_object($node)) {
            $nodeValues[] = $node->nodeValue;
            }
        }
        var_dump($nodeValues);
    }
}

