<?php

namespace Tests\FoodMeUp\AppBundle\Util\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImportCiqualTest extends WebTestCase
{
    public function testRun()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        $service = $container->get('foodmeup.import_ciqual');
        $result = $service->run('../../../Data/Table_Ciqual_2016.csv');
        $this->assertTrue(true, $result);
    }
}