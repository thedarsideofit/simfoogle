<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Document;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{

	/**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
	$fileNames =  $this->container->getParameter('fixture_files');
	$uploadPath =  $this->container->getParameter('upload_path');
	
	for($i=0;$i < 10; $i++) {
		$document = new Document();
		$document->setTitle('title files #'. $i);
		$document->setContent(file_get_contents($uploadPath.$fileNames[$i % 2]));
		$document->setFileName($fileNames[$i % 2]);
        $manager->persist($document);
	}

        $manager->flush();

    }
}
