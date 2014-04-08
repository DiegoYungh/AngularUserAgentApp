<?php

namespace Flyers\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GeoIp2\Exception\AddressNotFoundException;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $engine = $this->container->get('templating');
        $content = $engine->render('FrontendBundle:Default:index.html.twig');
        return new Response($content);
    }
}
