<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Log\Logger;

class LoggerMiddleware
{
    /**
     * The logger instance.
     *
     * @var 
     */
    protected Logger $logger;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Log an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->logger->info('Incoming request');
        return $next($request);
    }
}
