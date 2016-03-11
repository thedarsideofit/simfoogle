<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentControllerControllerTest extends WebTestCase
{
    public function testElasticSearch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/elastic/search/startup');
        
        // Assert that the response matches a given CSS selector.
        $this->assertGreaterThan(0, $crawler->filter('a')->count());        
    }
    public function testDataBaseSearch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/database/search/startup');
        
        // Assert that the response matches a given CSS selector.
        $this->assertGreaterThan(0, $crawler->filter('a')->count());
    }
    
    public function testDataBaseSearchWithIncorrectTerm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/database/search/argentina');
        
        
        // Assert that the response matches a given CSS selector.
        $this->assertGreaterThan(0, $crawler->filter('html:contains("No Results found")')->count());
    }
    
    public function testElasticSearchWithIncorrectTerm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/database/search/argentina');
        
        
        // Assert that the response matches a given CSS selector.
        $this->assertGreaterThan(0, $crawler->filter('html:contains("No Results found")')->count());
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Welcome to Symfoogle")')->count());
    }

}