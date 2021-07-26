# Fidely NET api wrapper
A PHP Wrapper for FidelyNET API.

## Getting started
This SDK lets you interact with `backoffice`, `customer` and `terminal` services. 
The simplest way of creating an instance of a service is using the `ServiceFactory::create()` method.
It requires 2 arguments, the first one is a string containing desired service, the second is an array containing the related authentication credentials provided by Data Loyalty along with some other optional parameters.

Example of using the factory to create a `terminal` service instance:
```php
use Blabs\FidelyNet\ServiceFactory;

// Creates an instance of the Terminal service.
$terminal_service = ServiceFactory::create('terminal', [
    'username' => 'wsTerminal01',
    'password' => 'password',
    'terminal' => '000001'
]);

// Uses the instance to query the service to getting info on a campaign id
/** @var \Blabs\FidelyNet\Services\TerminalService $terminal_service */
$terminal_service->getCampaign('1001');
```
## Supported keys for the `ServiceFactory` parameters array
Other than credentials, you can specify several options within the second argument of the `create()` method, many of them have already a default value, use following array keys if you need to override them.

* `username`
* `password`
* `terminal`
* `campaign_id`
* `demo_mode` (boolean)
* `session_persists` (boolean)
* `session_id_provider` (implementation of `\Blabs\FidelyNet\Contracts\SessionIdProviderContract` interface)
* `session_type` (can be `public` or `private`, available for `customer` service only)
* `http_client` (an instance of `GuzzleHttp\Client` or implementation of `GuzzleHttp\ClientInterface`)

```php
use Blabs\FidelyNet\ServiceFactory;

// Creates an instance of the Customer service, using a public session and with other customized options.
$customer_service = ServiceFactory::create('customer', [
    // required keys
    'username'          => 'myCustomerUserName',
    'password'          => 'myCustomerPassword',
    'campaign_id'       => '10000',
    // optional keys
    'demo_mode'         => true,
    'session_persists'  => false,
    'session_type'      => 'public',
]);
```

### Required parameters for each service
Each service needs some specific parameters in the config array in order to be instanced.
* `BackofficeService`
  * `username`
  * `password`
  
* `TerminalService` 
  * `username`
  * `password`
  * `terminal`
  
* `CustomerService`
  * `username`
  * `password`
  * `campaign_id`

## Session Persistence
FidelyNET APIs provides an authentication system that requires to open a session on the service before starting to make actual requests.

Usually you have to make a first request to authenticate passing your credentials, then you receive a session token that will be used to authorize all subsequent requests.
The token is valid for about 15 minutes from the last request made.

The SDK implements this mechanism automatically when creating an instance of the service, and it is also possible to persist the session id through multiple requests (even in multiple instances of the same service).
In case of failure of a request for an expired session, the client will automatically make a new login request, renewing the token and reiterating the failed request.

Session persistence is enabled by default when you use `ServiceFactory` class, you can override this option using `session_persists` array key in the second argument of the `create()` method. 
By default the SDK uses a session persistence "driver" that saves data in the temporary files system directory (typically `tmp/` on a *nix system), however you can create your own implementation of the persistence mechanism by implementing the `\Blabs\FidelyNet\Contracts\SessionIdProviderContract` interface (i.e. using session or any other storage system).


## Supported API Actions
So far the SDK supports fewer "actions" than those available on the service, our goal is to provide a library that simplify most common operations.

## Service methods reference
A full documentation about every method available on every service will be available ASAP

### Testing
```shell script
composer test
```