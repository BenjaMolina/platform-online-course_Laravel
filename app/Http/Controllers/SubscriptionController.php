<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            if (auth()->user()->subscribed('main')) { //'main' es donde se encuentran los planes
                return redirect('/')
                    ->with('message', ['warning', 'Actualmente ya estas suscrito a otro plan']);
            };
            return $next($request);

        })->only(['plans', 'proccessSubscription']);
    }

    public function plans()
    {
        return view('subscriptions.plans');
    }

    public function proccessSubscription()
    {
        return "aksdlkas";
    }
}
