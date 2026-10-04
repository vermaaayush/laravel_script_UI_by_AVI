@php
$config = DB::table('configs')->where('id', 1)->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt | {{ $config->bank_name ?? 'Equitable Bank' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('user_assets/new/assets/images/favicon.png') }}" sizes="16x16">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        primary: '#004226',
                        'primary-hover': '#0f5b38',
                        'accent-fixed': '#aaf2c4',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#f8faf9] text-[#191c1c] min-h-screen flex items-center justify-center p-4 antialiased font-sans">
    <div class="w-full max-w-lg">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold tracking-tight text-[#191c1c]">{{ $config->bank_name ?? 'Equitable Bank' }}</h1>
            <p class="text-xs text-[#53625b] mt-0.5">Wire Settlement & Transfer Gateway</p>
        </div>

        <div class="bg-white border border-[#e6e9e8] rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#004226]/5 rounded-full blur-3xl pointer-events-none"></div>

            @if(session('transfer_success_data'))
                <?php $data = session('transfer_success_data'); ?>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-200 text-amber-700 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[32px]">hourglass_top</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 border border-amber-200 text-amber-700 rounded-full text-[11px] font-bold tracking-wider uppercase mb-2">
                        Processing Clearance
                    </span>
                    <h2 class="text-2xl font-black text-[#191c1c] tracking-tight">Processing Fund Transfer</h2>
                    <p class="text-xs text-[#53625b] mt-1 max-w-sm mx-auto">
                        Your transaction has been queued into settlement. For expedited clearing, contact support via <span class="text-[#191c1c] font-semibold">{{ $config->bank_email }}</span>
                    </p>
                </div>

                <div class="bg-[#f8faf9] border border-[#e6e9e8] rounded-2xl p-5 mb-6 space-y-3.5">
                    <div class="flex items-center justify-between pb-3 border-b border-[#e6e9e8]">
                        <span class="text-xs font-semibold text-[#53625b] uppercase tracking-wider">Amount Transferred</span>
                        <div class="text-right">
                            <span class="text-lg font-black text-[#191c1c] font-mono">{{ number_format($data['amount'], 2) }}</span>
                            @if(isset($data['currency']) && $data['currency'] == "btc")
                                <span class="block text-xs text-amber-600 font-mono">({{ $data['btcEquivalent'] ?? '0' }} BTC)</span>
                            @elseif(isset($data['currency']) && $data['currency'] == "usdttrc20")
                                <span class="block text-xs text-emerald-700 font-mono">USDT</span>
                            @elseif(isset($data['currency']) && $data['currency'] == "eth")
                                <span class="block text-xs text-indigo-600 font-mono">ETH</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[#53625b]">Sent From</span>
                        <span class="font-mono font-semibold text-[#191c1c]">{{ $data['sent_from'] }}</span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="text-[#53625b]">Recipient</span>
                        <span class="font-mono font-semibold text-[#191c1c]">{{ $data['sent_to'] }}</span>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-3 border-t border-[#e6e9e8]">
                        <span class="text-[#53625b]">Transaction ID</span>
                        <span class="font-mono font-bold text-[#004226] px-2 py-0.5 bg-[#e8f7ee] rounded-md">{{ $data['transaction_id'] }}</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ url('index') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-md">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span> Return to Client Area
                    </a>
                </div>
            @else
                <div class="text-center py-6">
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[32px]">warning</span>
                    </div>
                    <h2 class="text-xl font-bold text-[#191c1c] mb-2">Transaction Details Unavailable</h2>
                    <p class="text-xs text-[#53625b] max-w-sm mx-auto mb-6">
                        No active transfer session was detected. If you completed a payment, please inspect your transaction ledger.
                    </p>
                    <a href="{{ url('index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-md">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span> Return to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
