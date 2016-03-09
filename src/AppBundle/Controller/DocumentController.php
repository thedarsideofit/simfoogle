<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DocumentController extends Controller
{
    /**
     * @Route("/{engine}/search/{query}", name="search")
     */
    public function searchAction($engine = 'elastic',$query)
    {
        if ($engine == 'elastic') {
            $finder = $this->container->get('fos_elastica.finder.app.document');
            $results = $finder->find($query);            
        } else {
            $results = $this->getDoctrine()->getRepository('AppBundle:Document')->search($query);
        }
        
        
        return $this->render('AppBundle:DocumentController:search.html.twig', array(
            'query' => $query,
            'documents' => $results
        ));
    }


    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:DocumentController:index.html.twig', array(
            // ...
        ));
    }

}
