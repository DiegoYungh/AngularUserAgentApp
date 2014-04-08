<?php

namespace Flyers\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Flyers\StoreBundle\Entity\Agent;

/**
 * @Route("/api")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/stop_bother")
     * @Method({"GET"})
     */
    public function cookieAction()
    {
        $response = new JsonResponse(array('status'=>200));
        $cookie = new Cookie('_uasbm', true, time() + 60 * 2);        
        $response->headers->setCookie($cookie);
        return $response;
    }

    /**
     * @Route("/agents")
     * @Method({"GET"})
     * @Cache(maxage="120", smaxage="120")
     */
    public function agentList(Request $request)
    {
        $params = $request->query->all();

        $agents = $this->getDoctrine()
            ->getRepository('StoreBundle:Agent')
            ->findAll();

        $serializer = $this->get('jms_serializer');
        return new Response($serializer->serialize($agents, 'json'));
    }

    /**
     * @Route("/agent/{id}", requirements={"id" = "\d+"})
     * @Method({"GET"})
     * @Cache(maxage="86400", smaxage="86400")
     */
    public function agentDetail(Request $request, $id = null)
    {

        $agent = $this->getDoctrine()
            ->getRepository('StoreBundle:Agent')
            ->find($id);

        if(!$agent){
            throw $this->createNotFoundException(
                'No Agent found for id '.$id
            );
        }

        $serializer = $this->get('jms_serializer');
        return new Response($serializer->serialize($agent, 'json'));
    }

    /**
     * @Route("/agents")
     * @Method({"POST"})
     */
    public function agentAdd(Request $request)
    {

        $data = json_decode($this->get("request")->getContent());

        $agent = new Agent();

        $agent->setIpAddress(
            $data->ipAddress);
        $agent->setUserAgentString(
            $data->userAgent->ua);
        # ID
        $agent->setBrowserName(
            $data->userAgent->browser->name);
        $agent->setBrowserVersion(
            $data->userAgent->browser->version);
        $agent->setEngineName(
            $data->userAgent->engine->name);
        $agent->setEngineVersion(
            $data->userAgent->engine->version);
        $agent->setOsName(
            $data->userAgent->os->name);
        $agent->setOsVersion(
            $data->userAgent->os->version);
        # Device
        if ($data->isMobile) {
            $agent->setDeviceName(
                $data->userAgent->device->name);
            $agent->setDeviceVersion(
                $data->userAgent->device->version);
        } else {
            $agent->setDeviceName(null);
            $agent->setDeviceVersion(null);
        }
        # Screen
        $agent->setScreenWidth(
            $data->screen->width);
        $agent->setScreenHeight(
            $data->screen->height);
        # Factor
        $agent->setDesktop(
            $data->isDesktop);
        $agent->setMobile(
            $data->isMobile);
        $agent->setCrawler(
        $data->isCrawler); # FIXME ADD CRAWLER DETECTION
        # Location
        $agent->setCountry(
            $data->country);
        $agent->setLatitude(
            $data->coords->lat);
        $agent->setLongitude(
            $data->coords->long);
        # Plugins
        $agent->setPluginFlash(
            $data->plugins->flash_enabled);
        $agent->setPluginWindowsMediaPlayer(
            $data->plugins->wmp_enabled);
        $agent->setPluginJava(
            $data->plugins->java_enabled);
        $agent->setPluginShockwave(
            $data->plugins->shockwave_enabled);
        $agent->setPluginQuicktime(
            $data->plugins->quicktime_enabled);
        $agent->setPluginRealPlayer(
            $data->plugins->real_player_enabled);
        $agent->setPluginAcrobatReader(
            $data->plugins->acrobat_reader_enabled);
        $agent->setPluginSvg(
            $data->plugins->svg_enabled);

        # Persist
        $em = $this->getDoctrine()->getManager();
        $em->persist($agent);
        $em->flush();

        $id = $agent->getId();

        $serializer = $this->get('jms_serializer');
        $agent = $serializer->serialize($agent, 'json');

        $response = new JsonResponse(array(
            'agentId'=>$id,
            'agent'=>$agent));

        # Stop asking for add...
        $cookie = new Cookie('_uawgtm', true, time() + 60 * 60 * 24 * 365);
        $response->headers->setCookie($cookie);

        return $response;

    }

    /**
     * @Route("/report/browser")
     * @Method({"GET"})
     * @Cache(maxage="120", smaxage="120")
     */
    public function reportBrowser(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(sprintf("SELECT a.%s, a.%s, COUNT(a.id) as share FROM %s a GROUP BY %s",
            'browser_name', 'browser_version', 'Flyers\StoreBundle\Entity\Agent', 'a.browser_name, a.browser_version'));
        $data = $query->getResult();

        // lets parse it a little
        $parsed = array();
        foreach ($data as $item) {
            try {
                $parsed[$item['browser_name']][$item['browser_version']] = $item['share'];
            } catch (Exception $e) {
                $parsed[$item['browser_name']] = array($item['browser_version'] => $item['share']);
            }
        }

        #$serializer = $this->get('jms_serializer');
        return new JsonResponse(array($parsed));
    }
}
