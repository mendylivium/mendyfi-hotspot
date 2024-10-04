<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait EwalletsHelper
{
    public function xenditCreatePayoutLink($apiKey, $data, $idempotency)
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$apiKey}:"),
            'Content-Type' => 'application/json',
            'idempotency-key' =>  $idempotency,
        ])->post('https://api.xendit.co/v2/payouts',$data);
    }

    public function xenditCreateDisbursement($apiKey, $data, $idempotency)
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$apiKey}:"),
            'Content-Type' => 'application/json',
            'X-IDEMPOTENCY-KEY' =>  $idempotency,
        ])->post('https://api.xendit.co/disbursements',$data);
    }

    public function xenditCreateInvoice($apiKey, $data)
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$apiKey}:"),
            'Content-Type' => 'application/json',
        ])->post('https://api.xendit.co/v2/invoices',$data);
    }

    public function xenditGetInvoice($apiKey, $invoiceId)
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$apiKey}:"),
            'Content-Type' => 'application/json',
        ])->get("https://api.xendit.co/v2/invoices/{$invoiceId}");
    }

    public function xenditGetDisburse($apiKey, $disburseId)
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$apiKey}:"),
            'Content-Type' => 'application/json',
        ])->get("https://api.xendit.co/disbursements/{$disburseId}");
    }

    public function xenditGetDisburseBanks($apiKey)
    {
        return Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$apiKey}:"),
            'Content-Type' => 'application/json',
        ])->get("https://api.xendit.co/available_disbursements_banks");
    }

}