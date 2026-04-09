<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $userMessage = $request->message;
        $apiKey = env('GEMINI_API_KEY');

        // System context about the shop
        $systemContext = "You are a helpful customer support assistant for 'የኛ ገበያ' (Yegna Gebya), an Ethiopian e-commerce platform. 
        You help customers with: product inquiries, order tracking, payment methods (Telebirr, CBEBirr, Bank Transfer), 
        shipping information, returns policy, and general shopping assistance.
        Always respond in Amharic (Ethiopian language) unless the user writes in English.
        Be friendly, concise and helpful. The shop sells electronics, clothing, sports items and more.
        Payment is done via Chapa (Telebirr, CBEBirr, Cards) and Bank Transfer.
        Delivery is available across Ethiopia. Return policy is 7 days.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemContext . "\n\nCustomer: " . $userMessage]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 300,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'ይቅርታ፣ አሁን መልስ መስጠት አልቻልኩም።';
                return response()->json(['reply' => $reply]);
            }

            return response()->json(['reply' => 'ይቅርታ፣ አሁን ችግር አለ። ቆይተው እንደገና ይሞክሩ።']);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'ይቅርታ፣ ግንኙነት ላይ ችግር አለ።']);
        }
    }
}
