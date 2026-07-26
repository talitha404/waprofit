<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Services\TransactionCalculatorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalculatorController extends Controller
{
    public function __construct(private readonly TransactionCalculatorService $calculator) {}

    public function index()
    {
        return view('calculator.index');
    }

    public function store(Request $request)
    {
        $input = $this->validatedInput($request);
        $result = $this->calculator->calculate($input);

        $this->storeCalculation($request, $input, $result);

        return redirect()->route('calculator.index')->with('success', 'Riwayat kalkulasi berhasil disimpan selama 3 bulan.');
    }

    public function pdf(Request $request)
    {
        $input = $this->validatedInput($request);
        $result = $this->calculator->calculate($input);

        if ($request->boolean('save_history')) {
            $this->storeCalculation($request, $input, $result);
        }

        $title = $input['title'] ?: 'Kalkulasi Profit Riil';
        $fileName = 'kalkulasi-profit-'.now()->format('Ymd-His').'.pdf';

        return Pdf::loadView('calculator.pdf', [
            'input' => $input,
            'result' => $result,
            'companyName' => $request->user()->company?->name ?? 'Waprofit',
            'generatedAt' => now()->timezone('Asia/Jakarta'),
            'title' => $title,
        ])->setPaper('a4')->download($fileName);
    }

    private function storeCalculation(Request $request, array $input, array $result): Calculation
    {
        abort_unless($request->user()->company_id, 422, 'Riwayat hanya dapat disimpan pada ruang kerja company.');

        return Calculation::create([
            'company_id' => $request->user()->company_id,
            'title' => $input['title'] ?: null,
            'input' => $input,
            'result' => $result,
            'expires_at' => Carbon::now()->addMonthsNoOverflow(3),
        ]);
    }

    private function validatedInput(Request $request): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'client_name' => ['nullable', 'string', 'max:120'],
            'client_dpp' => ['required', 'numeric', 'min:0', 'max:9999999999999999.99'],
            'client_ppn_enabled' => ['nullable', 'boolean'],
            'vendor_name' => ['nullable', 'string', 'max:120'],
            'vendor_dpp' => ['required', 'numeric', 'min:0', 'max:9999999999999999.99'],
            'vendor_ppn_enabled' => ['nullable', 'boolean'],
            'brokers' => ['nullable', 'array'],
            'brokers.*.name' => ['nullable', 'string', 'max:120'],
            'brokers.*.fee_type' => ['required', 'in:nominal,persentase'],
            'brokers.*.fee_value' => ['required', 'numeric', 'min:0', 'max:9999999999999999.99'],
            'brokers.*.pph_23_enabled' => ['nullable', 'boolean'],
            'save_history' => ['nullable', 'boolean'],
        ]);
    }
}
