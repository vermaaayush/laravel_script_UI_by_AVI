<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * IVR/Twilio webhook endpoints must return nothing but the TwiML XML body.
 * A single stray PHP notice/warning/deprecation (undefined index, null passed
 * to a typed argument, etc.) printed before the intended output is enough to
 * make Twilio reject the whole response with a 12100 "Document parse failure",
 * hanging up the call. This middleware buffers everything the controller
 * prints and discards any stray text, logging it instead of leaking it into
 * the response Twilio receives.
 */
class CleanTwimlOutput
{
    public function handle(Request $request, Closure $next)
    {
        ob_start();

        $response = $next($request);

        $stray = ob_get_clean();

        if ($stray !== false && trim($stray) !== '') {
            \Log::warning('IVR: stray output suppressed before TwiML response on ' . $request->fullUrl() . ': ' . $stray);
        }

        return $response;
    }
}
