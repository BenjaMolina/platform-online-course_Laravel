<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Reflection\DocBlock\Type\Collection;

class InvoiceController extends Controller
{
    public function admin()
    {
        $invoices = new Collection;

        if (auth()->user()->stripe_id) {
            $invoices = auth()->user()->invoices();
        }

        return view('invoices.admin', compact('invoices'));
    }

    public function download($id)
    {
        dd($id);
    }
}
