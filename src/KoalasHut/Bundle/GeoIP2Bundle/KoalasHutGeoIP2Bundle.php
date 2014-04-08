<?php

namespace KoalasHut\Bundle\GeoIP2Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use KoalasHut\Bundle\GeoIP2Bundle\GeoIP2;

class KoalasHutGeoIP2Bundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);
        try {
        	new GeoIP2();
        } catch (\Exception $e) {
        	// No file yet
        }
    }
}
