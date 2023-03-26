<?php

declare(strict_types=1);

namespace Schranz\Search\SEAL\Adapter\Opensearch\Tests;

use Schranz\Search\SEAL\Adapter\Opensearch\OpensearchAdapter;
use Schranz\Search\SEAL\Testing\AbstractAdapterTestCase;

class OpensearchAdapterTest extends AbstractAdapterTestCase
{
    public static function setUpBeforeClass(): void
    {
        $client = ClientHelper::getClient();
        self::$adapter = new OpensearchAdapter($client);

        parent::setUpBeforeClass();
    }
}
