<?php

namespace App\Http\Middleware;

use App\Models\Microsite;
use App\Support\CurrentMicrosite;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveMicrosite
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = (string) config('cafe.slug', 'kafe');

        $microsite = Microsite::withoutGlobalScopes()->where('slug', $slug)->first();

        abort_if(! $microsite, 404, 'Microsite tidak ditemukan.');
        abort_if(! $microsite->is_active, 503, 'Microsite sedang nonaktif.');

        app()->instance(CurrentMicrosite::class, $current = new CurrentMicrosite);
        $current->set($microsite);
        view()->share('microsite', $microsite);

        return $next($request);
    }
}
