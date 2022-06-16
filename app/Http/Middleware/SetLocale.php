<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $languages = config("app.languages"); // get languages from config/app.php
        if (in_array($request->lang, $languages)) {
            app()->setLocale($request->lang);  // set locale
            session()->put("language", $request->lang);  // make session
        } elseif (session("language")) {  // is has session
            if (in_array(session("language"), $languages))
                app()->setLocale(session("language"));
        }

        return $next($request);
    }
}
