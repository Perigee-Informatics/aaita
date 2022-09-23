<?php

namespace App\Http\Middleware;

use Closure;

class SecureHeadersMiddleware
{
    // Enumerate headers which you do not want in your application's responses.
    // Great starting point would be to go check out @Scott_Helme's:
    // https://securityheaders.com/
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $response = $next($request);
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Content-Security-Policy', $this->getCSP()); // Clearly, you will be more elaborate here.
        return $response;
    }
    private function getCSP(){
        return "default-src 'self' google.com gstatic.com ; img-src * 'unsafe-inline' data:; style-src 'self' 'unsafe-inline' https://* fonts.googleapis.com cdnjs.cloudflare.com unpkg.com code.jquery.com cdn.datatables.net cdn.jsdelivr.net stackpath.bootstrapcdn.com gstatic.com; script-src 'self' 'unsafe-inline' https://* 'unsafe-eval' cdn.jsdelivr.net unpkg.com cdnjs.cloudflare.com www.googletagmanager.com cdn.rawgit.com static.fusioncharts.com google.com code.highcharts.com gstatic.com ; font-src 'self' data: 'unsafe-inline' fonts.gstatic.com stackpath.bootstrapcdn.com cdnjs.cloudflare.com unpkg.com maxcdn.bootstrapcdn.com; connect-src 'self' www.google-analytics.com gstatic.com ;";
    }
    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}
