<?php
namespace Codific\Vault;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Log\LoggerInterface;

class ServiceFactory
{
    private static $services = [
        'sys' => 'Codific\Vault\Services\Sys',
        'data' => 'Codific\Vault\Services\Data',
        'transit' => 'Codific\Vault\Services\Transit',
        'auth/token' => 'Codific\Vault\Services\Auth\Token',
        'auth/userpass' => 'Codific\Vault\Services\Auth\UserPassword',
        'auth/videolab' => 'Codific\Vault\Services\Auth\Videolab',
    ];

    private $client;

    public function __construct(array $options = array(), LoggerInterface $logger = null, GuzzleClient $guzzleClient = null)
    {
        $this->client = new Client($options, $logger, $guzzleClient);
    }

    public function get($service)
    {
        if (!array_key_exists($service, self::$services)) {
            throw new \InvalidArgumentException(sprintf('The service "%s" is not available. Pick one among "%s".', $service, implode('", "', array_keys(self::$services))));
        }

        $class = self::$services[$service];

        return new $class($this->client);
    }
}
