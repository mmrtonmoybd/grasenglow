<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        $path = '/'.$request->path();
        $redirect = Redirect::query()
            ->where('old_path', $path)
            ->where('is_active', true)
            ->first();

        if ($redirect === null || $redirect->destination_url === $path) {
            return $next($request);
        }

        $redirect->increment('hit_count');

        return redirect()->to($redirect->destination_url, $redirect->status_code);
    }
}
