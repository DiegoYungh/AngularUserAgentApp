<?php

namespace KoalasHut\Bundle\GeoIP2Bundle\Controller;

use KoalasHut\Bundle\GeoIP2Bundle\GeoIP2;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GeoIp2\Exception\AddressNotFoundException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/api")
 */
class DefaultController extends Controller
{
	/**
     * @Route("/userInfo")
     * @Method({"GET"})
     */
    public function userInfo(Request $request)
    {

    	// To get location info
        $geoip = $this->get('geoip2');
        $reader = $geoip::getDatabaseReader();

        // user-agent was gathered message : aka _uawgtm
        // stop bothering me : aka _uasbm
        $is_registered = $request->cookies->get('_uawgtm', false) || $request->cookies->get('_uasbm', false);
        $user_agent = $request->headers->get('User-Agent');
        $ip_address = $request->server->get('REMOTE_ADDR');

        // Location
        try {
            $resource = $reader->city($ip_address);
            $country = $resource->country->names['en'] ?: '-';
            $latitude = $resource->location->latitude ?: '-';
            $longitude = $resource->location->longitude ?: '-';
        } catch (AddressNotFoundException $e) {
            $country = '-';
            $latitude = '-';
            $longitude = '-';
        }
        
        $response = array(
            'userAgentString' => $user_agent,
            'ipAddress' => $ip_address,
            'registered' => $is_registered,
            'country' => $country,
            'latitude' => $latitude,
            'longitude' => $longitude
        );

        return new JsonResponse($response);
    }
}
