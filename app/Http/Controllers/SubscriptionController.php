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

    public function proccessSubscription(Request $request)
    {

        $token = $request->stripeToken;

        try {
            if ($request->has('coupon')) {
                $request->user()->newSubscription('main', $request->type)
                    ->withCoupon($request->coupon)->create($token);
            } else {
                $request->user()->newSubscription('main', $request->type)
                    ->create($token);
            }

            return redirect()->route('subscriptions.admin')
                ->with('message', ['success', 'La suscripcion se ha llevao a cabo correctamente']);

        } catch (\Exception $exception) {
            $error = $exception->getMessage();
            return back()->with('message', ['danger', $error]);
        }
    }


    public function admin()
    {
        $subscriptions = auth()->user()->subscriptions;
        return view('subscriptions.admin', compact('subscriptions'));
    }

    public function resume(Request $request)
    {
        $subscription = $request->user()->subscription($request->plan);

        if ($subscription->cancelled() && $subscription->onGracePeriod()) {
            $request->user()->subscription($request->plan)->resume();

            return back()->with('message', ['success', "Has reanudado tu suscripcion correctamente"]);
        }

        return back();
    }

    public function cancel(Request $request)
    {
        auth()->user()->subscription($request->plan)->cancel();

        return back()->with('message', ['success', "La suscripcion se ha cancelado correctamente"]);
    }
}
