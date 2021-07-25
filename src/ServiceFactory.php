<?php


namespace Blabs\FidelyNet;


use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Constants\Messages;
use Blabs\FidelyNet\Exceptions\FidelyNetServiceException;
use Blabs\FidelyNet\Providers\SessionId\InMemorySessionIdProvider;
use Blabs\FidelyNet\Providers\SessionId\TmpDirSessionIdProvider;
use Blabs\FidelyNet\Services\ServiceAbstract;
use Blabs\FidelyNet\Support\Arr;
use InvalidArgumentException;

final class ServiceFactory
{
    /**
     * Creates and instance of a FNET service
     *
     * @param string $serviceType
     * @param array $options
     * @return ServiceAbstract
     * @throws FidelyNetServiceException
     */
    public static function create(string $serviceType, array $options) :ServiceAbstract
    {
        if (!array_key_exists($serviceType, FactoryOptions::SERVICE_CLASSES)) {
            throw new InvalidArgumentException(Messages::UNSUPPORTED_SERVICE_TYPE);
        }

        // Parse and prepare options array
        $options = self::parseOptions($serviceType, $options);

        // Create an instance of Client class
        $client = new Client(
            $serviceType,
            self::createCredentialsArray($serviceType, $options),
            $options[FactoryOptions::DEMO_MODE],
            $options[FactoryOptions::SESSION_TYPE],
            $options[FactoryOptions::SESSION_ID_PROVIDER],
            $options[FactoryOptions::HTTP_CLIENT],
            $options[FactoryOptions::START_SESSION]
        );

        // Instance service's class
        $service_class = FactoryOptions::SERVICE_CLASSES[$serviceType];
        return new $service_class($client);
    }

    /**
     * Parses all factory options
     *
     * @param string $serviceType
     * @param array $options
     * @return array
     * @throws FidelyNetServiceException
     */
    private static function parseOptions(string $serviceType, array $options) :array
    {
        $options = self::setDefaultOptions($serviceType, $options);
        $session_type = $options[FactoryOptions::SESSION_TYPE];

        if ($session_type === ApiSessionTypes::PUBLIC and $serviceType !== ApiServices::CUSTOMER) {
            throw new FidelyNetServiceException(Messages::UNSUPPORTED_ACTION);
        }

        self::checkServiceRequiredOptions($serviceType, $session_type, $options);

        return $options;
    }

    /**
     * Checks if all required service specific options are provided
     *
     * @param string $service
     * @param string $session_type
     * @param array $options
     */
    private static function checkServiceRequiredOptions(string $service, string $session_type, array $options) :void
    {
        $missing_service_required_options = Arr::getMissingRequiredOptions(FactoryOptions::SERVICES_REQUIRED_OPTIONS[$session_type][$service], $options);
        if (count($missing_service_required_options) > 0) {
            throw new InvalidArgumentException(Messages::MISSING_REQUIRED_SERVICE_OPTIONS. implode(', ', $missing_service_required_options));
        }
    }

    /**
     * Fills options array with a set of default values
     *
     * @param string $serviceType
     * @param $options
     * @return array
     */
    private static function setDefaultOptions(string $serviceType, $options) :array
    {
        $default_options = $options;

        $default_options[FactoryOptions::DEMO_MODE] = array_key_exists(FactoryOptions::DEMO_MODE, $options) ?
            $options[FactoryOptions::DEMO_MODE] : FactoryOptions::DEFAULT_VALUES[FactoryOptions::DEMO_MODE];

        $default_options[FactoryOptions::SESSION_TYPE] = array_key_exists(FactoryOptions::SESSION_TYPE, $options) ?
            $options[FactoryOptions::SESSION_TYPE] : FactoryOptions::DEFAULT_VALUES[FactoryOptions::SESSION_TYPE];

        $default_options[FactoryOptions::SESSION_PERSISTS] = array_key_exists(FactoryOptions::SESSION_PERSISTS, $options) ?
            $options[FactoryOptions::SESSION_PERSISTS] : FactoryOptions::DEFAULT_VALUES[FactoryOptions::SESSION_PERSISTS];

        $default_options[FactoryOptions::SESSION_ID_PROVIDER] = array_key_exists(FactoryOptions::SESSION_ID_PROVIDER, $options) ?
            $options[FactoryOptions::SESSION_ID_PROVIDER]
            : (
                ($default_options[FactoryOptions::SESSION_PERSISTS]) ?
                    new TmpDirSessionIdProvider(
                        $serviceType ."__". $default_options[FactoryOptions::SESSION_TYPE]
                    )
                    : new InMemorySessionIdProvider()
            );

        $default_options[FactoryOptions::HTTP_CLIENT] = array_key_exists(FactoryOptions::HTTP_CLIENT, $options) ?
            $options[FactoryOptions::HTTP_CLIENT] : FactoryOptions::DEFAULT_VALUES[FactoryOptions::HTTP_CLIENT];

        $default_options[FactoryOptions::START_SESSION] = array_key_exists(FactoryOptions::START_SESSION, $options) ?
            $options[FactoryOptions::START_SESSION] : FactoryOptions::DEFAULT_VALUES[FactoryOptions::START_SESSION];

        return $default_options;
    }

    /**
     * Creates an array with service credentials
     *
     * @param string $serviceType
     * @param array $options
     * @return array
     */
    private static function createCredentialsArray(string $serviceType, array $options) :array
    {
        $default_credentials = $options[FactoryOptions::SESSION_TYPE] === ApiSessionTypes::PUBLIC ? []
            : [
                FactoryOptions::USERNAME => $options[FactoryOptions::USERNAME],
                FactoryOptions::PASSWORD => $options[FactoryOptions::PASSWORD],
            ];

        switch ($serviceType) {
        case ApiServices::TERMINAL:
            $additional_parameters = [
                FactoryOptions::TERMINAL => $options[FactoryOptions::TERMINAL]
            ];
            break;
        case ApiServices::CUSTOMER:
            $additional_parameters = [
                FactoryOptions::CAMPAIGN_ID => $options[FactoryOptions::CAMPAIGN_ID]
            ];
            break;
        case ApiServices::BACKOFFICE:
        default:
            $additional_parameters = [];
        }

        return array_merge($default_credentials, $additional_parameters);
    }
}
