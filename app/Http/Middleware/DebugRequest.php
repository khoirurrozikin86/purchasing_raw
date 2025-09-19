// Dalam App\Http\Middleware\DebugRequest.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugRequest
{
    public function handle(Request $request, Closure $next)
    {
        Log::debug('Accessing URL: ' . $request->url());
        return $next($request);
    }
}
