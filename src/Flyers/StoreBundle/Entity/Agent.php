<?php

namespace Flyers\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Flyers\StoreBundle\Entity\AgentRepository")
 * @ORM\Table(name="agent")
 */
class Agent
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $ip_address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $user_agent_string;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $browser_name;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $browser_version;
    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    protected $engine_name;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $engine_version;
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $os_name;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $os_version;
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $device_name;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $device_version;
    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $screen_width;
    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $screen_height;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $desktop = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $mobile = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $crawler = false;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $country;
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $latitude;
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $longitude;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_flash = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_windows_media_player = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_java = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_shockwave = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_quicktime = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_real_player = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_acrobat_reader = false;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $plugin_svg = false;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Agent
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set ip_address
     *
     * @param string $ipAddress
     * @return Agent
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = $ipAddress;

        return $this;
    }

    /**
     * Get ip_address
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Set user_agent_string
     *
     * @param string $userAgentString
     * @return Agent
     */
    public function setUserAgentString($userAgentString)
    {
        $this->user_agent_string = $userAgentString;

        return $this;
    }

    /**
     * Get user_agent_string
     *
     * @return string 
     */
    public function getUserAgentString()
    {
        return $this->user_agent_string;
    }

    /**
     * Set browser_name
     *
     * @param string $browserName
     * @return Agent
     */
    public function setBrowserName($browserName)
    {
        $this->browser_name = $browserName;

        return $this;
    }

    /**
     * Get browser_name
     *
     * @return string 
     */
    public function getBrowserName()
    {
        return $this->browser_name;
    }

    /**
     * Set browser_version
     *
     * @param string $browserVersion
     * @return Agent
     */
    public function setBrowserVersion($browserVersion)
    {
        $this->browser_version = $browserVersion;

        return $this;
    }

    /**
     * Get browser_version
     *
     * @return string 
     */
    public function getBrowserVersion()
    {
        return $this->browser_version;
    }

    /**
     * Set engine_name
     *
     * @param string $engineName
     * @return Agent
     */
    public function setEngineName($engineName)
    {
        $this->engine_name = $engineName;

        return $this;
    }

    /**
     * Get engine_name
     *
     * @return string 
     */
    public function getEngineName()
    {
        return $this->engine_name;
    }

    /**
     * Set engine_version
     *
     * @param string $engineVersion
     * @return Agent
     */
    public function setEngineVersion($engineVersion)
    {
        $this->engine_version = $engineVersion;

        return $this;
    }

    /**
     * Get engine_version
     *
     * @return string 
     */
    public function getEngineVersion()
    {
        return $this->engine_version;
    }

    /**
     * Set os_name
     *
     * @param string $osName
     * @return Agent
     */
    public function setOsName($osName)
    {
        $this->os_name = $osName;

        return $this;
    }

    /**
     * Get os_name
     *
     * @return string 
     */
    public function getOsName()
    {
        return $this->os_name;
    }

    /**
     * Set os_version
     *
     * @param string $osVersion
     * @return Agent
     */
    public function setOsVersion($osVersion)
    {
        $this->os_version = $osVersion;

        return $this;
    }

    /**
     * Get os_version
     *
     * @return string 
     */
    public function getOsVersion()
    {
        return $this->os_version;
    }

    /**
     * Set device_name
     *
     * @param string $deviceName
     * @return Agent
     */
    public function setDeviceName($deviceName)
    {
        $this->device_name = $deviceName;

        return $this;
    }

    /**
     * Get device_name
     *
     * @return string 
     */
    public function getDeviceName()
    {
        return $this->device_name;
    }

    /**
     * Set device_version
     *
     * @param string $deviceVersion
     * @return Agent
     */
    public function setDeviceVersion($deviceVersion)
    {
        $this->device_version = $deviceVersion;

        return $this;
    }

    /**
     * Get device_version
     *
     * @return string 
     */
    public function getDeviceVersion()
    {
        return $this->device_version;
    }

    /**
     * Set screen_width
     *
     * @param integer $screenWidth
     * @return Agent
     */
    public function setScreenWidth($screenWidth)
    {
        $this->screen_width = $screenWidth;

        return $this;
    }

    /**
     * Get screen_width
     *
     * @return integer 
     */
    public function getScreenWidth()
    {
        return $this->screen_width;
    }

    /**
     * Set screen_height
     *
     * @param integer $screenHeight
     * @return Agent
     */
    public function setScreenHeight($screenHeight)
    {
        $this->screen_height = $screenHeight;

        return $this;
    }

    /**
     * Get screen_height
     *
     * @return integer 
     */
    public function getScreenHeight()
    {
        return $this->screen_height;
    }

    /**
     * Set desktop
     *
     * @param boolean $desktop
     * @return Agent
     */
    public function setDesktop($desktop)
    {
        $this->desktop = $desktop;

        return $this;
    }

    /**
     * Get desktop
     *
     * @return boolean 
     */
    public function getDesktop()
    {
        return $this->desktop;
    }

    /**
     * Set mobile
     *
     * @param boolean $mobile
     * @return Agent
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return boolean 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set crawler
     *
     * @param boolean $crawler
     * @return Agent
     */
    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;

        return $this;
    }

    /**
     * Get crawler
     *
     * @return boolean 
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Agent
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Agent
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Agent
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set plugin_flash
     *
     * @param boolean $pluginFlash
     * @return Agent
     */
    public function setPluginFlash($pluginFlash)
    {
        $this->plugin_flash = $pluginFlash;

        return $this;
    }

    /**
     * Get plugin_flash
     *
     * @return boolean 
     */
    public function getPluginFlash()
    {
        return $this->plugin_flash;
    }

    /**
     * Set plugin_windows_media_player
     *
     * @param boolean $pluginWindowsMediaPlayer
     * @return Agent
     */
    public function setPluginWindowsMediaPlayer($pluginWindowsMediaPlayer)
    {
        $this->plugin_windows_media_player = $pluginWindowsMediaPlayer;

        return $this;
    }

    /**
     * Get plugin_windows_media_player
     *
     * @return boolean 
     */
    public function getPluginWindowsMediaPlayer()
    {
        return $this->plugin_windows_media_player;
    }

    /**
     * Set plugin_java
     *
     * @param boolean $pluginJava
     * @return Agent
     */
    public function setPluginJava($pluginJava)
    {
        $this->plugin_java = $pluginJava;

        return $this;
    }

    /**
     * Get plugin_java
     *
     * @return boolean 
     */
    public function getPluginJava()
    {
        return $this->plugin_java;
    }

    /**
     * Set plugin_shockwave
     *
     * @param boolean $pluginShockwave
     * @return Agent
     */
    public function setPluginShockwave($pluginShockwave)
    {
        $this->plugin_shockwave = $pluginShockwave;

        return $this;
    }

    /**
     * Get plugin_shockwave
     *
     * @return boolean 
     */
    public function getPluginShockwave()
    {
        return $this->plugin_shockwave;
    }

    /**
     * Set plugin_quicktime
     *
     * @param boolean $pluginQuicktime
     * @return Agent
     */
    public function setPluginQuicktime($pluginQuicktime)
    {
        $this->plugin_quicktime = $pluginQuicktime;

        return $this;
    }

    /**
     * Get plugin_quicktime
     *
     * @return boolean 
     */
    public function getPluginQuicktime()
    {
        return $this->plugin_quicktime;
    }

    /**
     * Set plugin_real_player
     *
     * @param boolean $pluginRealPlayer
     * @return Agent
     */
    public function setPluginRealPlayer($pluginRealPlayer)
    {
        $this->plugin_real_player = $pluginRealPlayer;

        return $this;
    }

    /**
     * Get plugin_real_player
     *
     * @return boolean 
     */
    public function getPluginRealPlayer()
    {
        return $this->plugin_real_player;
    }

    /**
     * Set plugin_acrobat_reader
     *
     * @param boolean $pluginAcrobatReader
     * @return Agent
     */
    public function setPluginAcrobatReader($pluginAcrobatReader)
    {
        $this->plugin_acrobat_reader = $pluginAcrobatReader;

        return $this;
    }

    /**
     * Get plugin_acrobat_reader
     *
     * @return boolean 
     */
    public function getPluginAcrobatReader()
    {
        return $this->plugin_acrobat_reader;
    }

    /**
     * Set plugin_svg
     *
     * @param boolean $pluginSvg
     * @return Agent
     */
    public function setPluginSvg($pluginSvg)
    {
        $this->plugin_svg = $pluginSvg;

        return $this;
    }

    /**
     * Get plugin_svg
     *
     * @return boolean 
     */
    public function getPluginSvg()
    {
        return $this->plugin_svg;
    }
}
