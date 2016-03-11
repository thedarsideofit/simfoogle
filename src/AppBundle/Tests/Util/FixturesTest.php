<?php
namespace AppBundle\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Bundle\FrameworkBundle\Client;

class FixturesTest extends WebTestCase
{
        
    public function testInsertDocumentsByFixture()
     {
         $client = static::createClient();
         $output = $this->runCommand($client, "doctrine:database:create");
         $output = $this->runCommand($client, "doctrine:schema:update --force");
         // I can't remove the question of the Careful, database will be purged. Do you want to continue y/N ? in command
         $output = $this->runCommand($client, "doctrine:fixtures:load --no-interaction");

         $em = $client->getKernel()->getContainer()->get('doctrine')->getManager();

         $documents = $em->getRepository('AppBundle:Document')->find();

         $this->assertGreaterThan(0,$documents->count());
     }
     
     /**
     * Runs a command and returns it output
     */
    public function runCommand(Client $client, $command)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        $fp = tmpfile();
        $input = new StringInput($command);
        $output = new StreamOutput($fp);

        $application->run($input, $output);

        fseek($fp, 0);
        $output = '';
        while (!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;
    }
}