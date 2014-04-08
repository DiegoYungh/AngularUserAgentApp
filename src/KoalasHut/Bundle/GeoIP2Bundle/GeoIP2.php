<?php
/**
 * Extracted from whitworf/geoip2
 * https://github.com/whitworf/geoip2/
 */

namespace KoalasHut\Bundle\GeoIP2Bundle;

use GeoIp2\Database\Reader;

class GeoIP2 {

    private static $databaseReader = null;

    public function __construct() {

        if (self::$databaseReader == null) {

            
            $filename = dirname(__FILE__) . "/Resources/data/GeoLite2-City.mmdb";
            
            if (!file_exists($filename)){
                throw new \Exception("Geo database file does not exist");
            }

            self::$databaseReader = new Reader($filename);
        }

    }

    /**
     * @return \GeoIp2\Database\Reader
     */
    public static function getDatabaseReader() {
        return self::$databaseReader;
    }

    /**
     * @param \GeoIp2\Database\Reader $reader
     */
    public static function setDatabaseReader($reader) {
        self::$databaseReader = $reader;
    }


} 