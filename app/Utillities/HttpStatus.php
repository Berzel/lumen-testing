<?php

namespace App\Utillities;

class HttpStatus
{
    /** Standard response for successful HTTP requests */
    public const OK = 200;
    /** The request has been fulfilled and resulted in a new resource beign created */
    public const CREATED = 201;
    /** Request has been accepted for processing but has not been completed */
    public const ACCEPTED = 202;
    /** The server has successfully processed the request but is returning no content */
    public const NO_CONTENT = 204;


    /** The request can not be fulfilled due to bad syntax */
    public const BAD_REQUEST = 400;
    /** For use when authentication is possible and has failed or has not been provided */
    public const UNAUTHORIZED = 401;
    /** Reserved for future use. To be used as part of some digital payment scheme */
    public const PAYMENT_REQUIRED = 402;
    /** Server refused to process your request and authenticating will make no difference */
    public const FORBIDDEN = 403;
    /** The requested resource could not be found */
    public const NOT_FOUND = 404;
    /** Request methos not supported by that resource */
    public const METHOD_NOT_ALLOWED = 405;
    /** Resourcec is not capable of generating content according to the accept header of the request */
    public const NOT_ACCEPTABLE = 406;
    /** The client must first authenticate itself with the proxy */
    public const PROXY_AUTHENTICATION_REQUIRED = 407;
    /** The server timed out waiting for a response */
    public const REQUEST_TIMEOUT = 408;
    /** The request was well formed but was unable to be followed due to semantic errors */
    public const UNPROCESSABLE_ENTITY = 422;
}
