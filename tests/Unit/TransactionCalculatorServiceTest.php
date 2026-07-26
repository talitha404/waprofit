<?php

use App\Services\TransactionCalculatorService;

it('calculates taxes, broker fees, and net profit from decimal-safe inputs', function () {
    $result = app(TransactionCalculatorService::class)->calculate([
        'client_dpp' => '100000000',
        'vendor_dpp' => '70000000',
        'client_ppn_enabled' => true,
        'vendor_ppn_enabled' => true,
        'brokers' => [[
            'name' => 'Broker A',
            'fee_type' => 'persentase',
            'fee_value' => '10',
            'pph_23_enabled' => true,
        ]],
    ]);

    expect($result['ppn_keluaran'])->toBe('11000000')
        ->and($result['ppn_masukan'])->toBe('7700000')
        ->and($result['posisi_ppn'])->toBe('3300000')
        ->and($result['total_fee_bruto'])->toBe('3000000')
        ->and($result['total_pph_broker'])->toBe('60000')
        ->and($result['total_fee_netto'])->toBe('2940000')
        ->and($result['estimasi_laba_bersih'])->toBe('23760000');
});

it('sets percentage broker fees to zero when the DPP difference is negative', function () {
    $result = app(TransactionCalculatorService::class)->calculate([
        'client_dpp' => '50000',
        'vendor_dpp' => '75000',
        'client_ppn_enabled' => false,
        'vendor_ppn_enabled' => false,
        'brokers' => [[
            'fee_type' => 'persentase',
            'fee_value' => '5',
            'pph_23_enabled' => true,
        ]],
    ]);

    expect($result['total_fee_bruto'])->toBe('0')
        ->and($result['estimasi_laba_bersih'])->toBe('-25000')
        ->and($result['warnings'])->not->toBeEmpty();
});
