<?php

namespace App\Services;

use InvalidArgumentException;

class TransactionCalculatorService
{
    private const VAT_RATE = '0.11';

    private const PPH_23_RATE = '0.02';

    private const SCALE = 8;

    /**
     * Menghitung estimasi transaksi dari input yang sudah tervalidasi.
     * Semua operasi uang menggunakan BCMath agar tidak bergantung pada float.
     */
    public function calculate(array $input): array
    {
        $clientDpp = $this->money($input['client_dpp'] ?? '0');
        $vendorDpp = $this->money($input['vendor_dpp'] ?? '0');
        $clientVatEnabled = $this->boolean($input['client_ppn_enabled'] ?? true);
        $vendorVatEnabled = $this->boolean($input['vendor_ppn_enabled'] ?? true);

        $vatOutput = $clientVatEnabled ? $this->tax($clientDpp, self::VAT_RATE) : '0';
        $vatInput = $vendorVatEnabled ? $this->tax($vendorDpp, self::VAT_RATE) : '0';
        $vatPosition = bcsub($vatOutput, $vatInput, self::SCALE);
        $dppDifference = bcsub($clientDpp, $vendorDpp, self::SCALE);

        $fees = [];
        $totalGrossFee = '0';
        $totalFeeTax = '0';
        $totalNetFee = '0';

        foreach ($input['brokers'] ?? [] as $broker) {
            $fee = $this->calculateFee($broker, $dppDifference);
            $totalGrossFee = bcadd($totalGrossFee, $fee['_gross'], self::SCALE);
            $totalFeeTax = bcadd($totalFeeTax, $fee['_pph_23'], self::SCALE);
            $totalNetFee = bcadd($totalNetFee, $fee['_net'], self::SCALE);
            unset($fee['_gross'], $fee['_pph_23'], $fee['_net']);
            $fees[] = $fee;
        }

        $payableVat = bccomp($vatPosition, '0', self::SCALE) > 0 ? $vatPosition : '0';
        $netProfit = bcsub(bcsub($dppDifference, $payableVat, self::SCALE), $totalNetFee, self::SCALE);

        return [
            'rates' => ['ppn' => 11, 'pph_23' => 2],
            'client_dpp' => $this->rupiah($clientDpp),
            'vendor_dpp' => $this->rupiah($vendorDpp),
            'ppn_keluaran' => $this->rupiah($vatOutput),
            'ppn_masukan' => $this->rupiah($vatInput),
            'posisi_ppn' => $this->rupiah($vatPosition),
            'status_ppn' => bccomp($vatPosition, '0', self::SCALE) > 0 ? 'Kurang Bayar' : (bccomp($vatPosition, '0', self::SCALE) < 0 ? 'Lebih Bayar PPN' : 'Nihil PPN'),
            'pph_23_penerimaan' => $this->rupiah($this->tax($clientDpp, self::PPH_23_RATE)),
            'pph_23_vendor' => $this->rupiah($this->tax($vendorDpp, self::PPH_23_RATE)),
            'selisih_dpp' => $this->rupiah($dppDifference),
            'fees' => $fees,
            'total_fee_bruto' => $this->rupiah($totalGrossFee),
            'total_pph_broker' => $this->rupiah($totalFeeTax),
            'total_fee_netto' => $this->rupiah($totalNetFee),
            'estimasi_laba_bersih' => $this->rupiah($netProfit),
            'warnings' => bccomp($dppDifference, '0', self::SCALE) < 0
                ? ['Selisih DPP negatif. Fee berbasis persentase dihitung Rp0; transaksi perlu ditinjau.']
                : [],
        ];
    }

    private function calculateFee(array $broker, string $dppDifference): array
    {
        $type = ($broker['fee_type'] ?? 'nominal') === 'persentase' ? 'persentase' : 'nominal';
        $value = $this->money($broker['fee_value'] ?? '0');
        $gross = $type === 'persentase'
            ? (bccomp($dppDifference, '0', self::SCALE) > 0 ? bcdiv(bcmul($value, $dppDifference, self::SCALE), '100', self::SCALE) : '0')
            : $value;
        $tax = $this->boolean($broker['pph_23_enabled'] ?? true) ? $this->tax($gross, self::PPH_23_RATE) : '0';

        return [
            'name' => $broker['name'] ?? null,
            'fee_type' => $type,
            'fee_value' => $type === 'persentase' ? $this->decimal($broker['fee_value'] ?? '0') : $this->rupiah($value),
            'gross' => $this->rupiah($gross),
            'pph_23' => $this->rupiah($tax),
            'net' => $this->rupiah(bcsub($gross, $tax, self::SCALE)),
            '_gross' => $gross,
            '_pph_23' => $tax,
            '_net' => bcsub($gross, $tax, self::SCALE),
        ];
    }

    private function tax(string $amount, string $rate): string
    {
        return bcmul($amount, $rate, self::SCALE);
    }

    private function money(mixed $value): string
    {
        $value = $this->decimal($value);
        if (bccomp($value, '0', self::SCALE) < 0) {
            throw new InvalidArgumentException('Nilai uang tidak boleh negatif.');
        }

        return $value;
    }

    private function decimal(mixed $value): string
    {
        $value = trim((string) $value);
        if ($value === '' || ! preg_match('/^\d+(\.\d{1,8})?$/', $value)) {
            throw new InvalidArgumentException('Nilai angka tidak valid.');
        }

        return bcadd($value, '0', self::SCALE);
    }

    private function rupiah(string $value): string
    {
        $negative = bccomp($value, '0', self::SCALE) < 0;
        $absolute = $negative ? bcsub('0', $value, self::SCALE) : $value;
        $whole = bcdiv($absolute, '1', 0);
        $fraction = bcsub($absolute, $whole, self::SCALE);

        if (bccomp($fraction, '0.5', self::SCALE) >= 0) {
            $whole = bcadd($whole, '1', 0);
        }

        return $negative && $whole !== '0' ? '-'.$whole : $whole;
    }

    private function boolean(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
    }
}
