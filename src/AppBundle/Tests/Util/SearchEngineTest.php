<?php
// tests/AppBundle/Util/CalculatorTest.php
namespace Tests\AppBundle\Util;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchEngineTest extends WebTestCase
{ 
    public function testSearchEngines() 
    {
        $client = static::createClient();
        $elasticFinder = $client->getKernel()->getContainer()->get('fos_elastica.finder.app.document');
        $elasticResults = $elasticFinder->find('fowler');            
        
        $em = $client->getKernel()->getContainer()->get('doctrine')->getManager();
        $dataBaseResults = $em->getRepository('AppBundle:Document')->search('fowler');
        
        $this->assertEquals(count($elasticResults), count($dataBaseResults));  
        
    }
}