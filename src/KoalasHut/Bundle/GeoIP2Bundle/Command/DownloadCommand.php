<?php

namespace KoalasHut\Bundle\GeoIP2Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

# Extracted from whitworf/geoip2
# https://github.com/whitworf/geoip2/blob/master/src/Command/UpdateDatabaseCommand.php

class DownloadCommand extends ContainerAwareCommand
{
	/**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('geoip2:download_db')
            ->setDefinition(array(
                new InputArgument('db_url', InputArgument::OPTIONAL, 'DB URL', 'http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz'),
            ))
            ->setDescription('Grabs the data from the url');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $dataDir = $this->getDataDirectoryPath();
        if (!file_exists($dataDir)) {
            mkdir($dataDir);
        }

        $url = $input->getArgument('db_url');

        $tempFilename = tempnam($dataDir, 'countryFile') . ".gz";
        $dataDownloadPath = $dataDir . "/GeoLite2-City.mmdb";
        $outputFile = fopen($tempFilename, 'wb');

        $output->writeln(sprintf("Beginning download of file: %s", $url));
        set_time_limit(0); // unlimited max execution time
        $options = array(
            CURLOPT_FILE => $outputFile,
            CURLOPT_TIMEOUT => 28800,
            CURLOPT_URL => $url
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);


        $output->writeln("Download complete");

        $output->writeln("De-compressing file");

        $outputUncompressedTempFileName = $this->decompressFile($tempFilename);

        $output->writeln("Decompression complete");

        rename($outputUncompressedTempFileName, $dataDownloadPath);
        chmod($dataDownloadPath, 0x777);
    }

    private function getDataDirectoryPath() {
        return dirname(__FILE__) . "/../Resources/data";
    }

    /**
     * @param $filename
     * @return string
     */
    protected function decompressFile($filename) {

        $dataDir = $this->getDataDirectoryPath();

        $zip = gzopen($filename, 'rb');

        $outputUncompressedTempFileName = tempnam($dataDir, 'dbupdate');

        $outputUncompressedTempFile = fopen($outputUncompressedTempFileName, 'wb');

        $bufferSize = 4096;

        while (!gzeof($zip)) {
            fwrite($outputUncompressedTempFile, gzread($zip, $bufferSize));
        }

        fclose($outputUncompressedTempFile);
        gzclose($zip);

        return $outputUncompressedTempFileName;
    }
}