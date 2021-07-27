<?php

namespace Blabs\FidelyNet\Constants;

final class Messages
{
    const UNKNOWN_ERROR = 'Unknown error';
    const MISSING_SERVICE_TYPE = 'A Service type must be specified';
    const MISSING_REQUIRED_FACTORY_OPTIONS = 'Missing required factory options: ';
    const MISSING_REQUIRED_SERVICE_OPTIONS = 'Missing one or more service parameters: ';
    const MISSING_CREDENTIALS_PARAMETER = 'Missing one or more credentials';
    const UNSUPPORTED_SERVICE_TYPE = 'Unsupported service type specified';
    const UNSUPPORTED_ACTION = 'Unsupported action for this service';
    const UNSUPPORTED_ACTION_WITH_PUBLIC_SESSION = 'Can\'t run this action with a public session';

    const MAX_SESSION_RENEWS = 'Session has been renewed too many times';
    const SERVICE_UNREACHABLE = 'FidelyNET web service is unreachable';
    const SERVICE_REPLIED_WITH_HTTP_ERROR_CODE = 'FidelyNET web service returned an http error code: ';
    const SERVICE_BAD_REQUEST = 'FidelyNET web service returned a "bad request" error, check request format';
    const SERVICE_RETURNED_ERROR_CODE = 'FidelyNET web service returned an error code - ';
    const SERVICE_MISSING_REQUIRED_FIELDS = 'FidelyNET web service said that some required fields are missing from the request data';
}
