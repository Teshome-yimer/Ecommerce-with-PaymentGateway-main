<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChapaController extends Controller
{
    public function pay($amount)
    {
        $reference = "TEST_" . uniqid();

        $response = Http::withToken(env('CHAPA_SECRET_KEY'))->post('https://api.chapa.co/v1/transaction/initialize', [
            'amount' => $amount,
            'currency' => "ETB",
            'email' => auth()->user()->email,
            'tx_ref' => $reference,
            'callback_url' => "https://webhook.site/0000-0000", // ለወደፊቱ የምንቀይረው
            'first_name' => auth()->user()->name,
            'last_name' => "Customer",
        ]);

        if ($response->successful()) {
            return redirect($response->json()['data']['checkout_url']);
        }

        return back()->with('error', 'ክፍያ መጀመር አልተቻለም።');
    }
}