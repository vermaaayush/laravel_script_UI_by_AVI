@php
$config = DB::table('configs')->where('id', 1)->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt | {{ $config->bank_name ?? 'Bank' }}</title>
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
                        primary: '#c59b27',
                        'primary-hover': '#dfbb58',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0f131a] text-slate-100 min-h-screen flex items-center justify-center p-4 antialiased font-sans">
    <div class="w-full max-w-lg">
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold tracking-tight text-white">{{ $config->bank_name ?? 'Bank' }}</h1>
            <p class="text-xs text-slate-400 mt-0.5">Wire Settlement & Transfer Gateway</p>
        </div>

        <div class="bg-[#181d27] border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden backdrop-blur-sm">
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>

            @if(session('transfer_success_data'))
                <?php $data = session('transfer_success_data'); ?>
                <div class="text-center mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[32px]">hourglass_top</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-full text-[11px] font-bold tracking-wider uppercase mb-2">
                        Processing Clearance
                    </span>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Processing Fund Transfer</h2>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Your transaction has been queued into settlement. For expedited clearing, contact support via <span class="text-slate-200 font-semibold">{{ $config->bank_email }}</span>
                    </p>
                </div>

                <div class="bg-[#11141c] border border-slate-800/80 rounded-2xl p-5 mb-6 space-y-3.5">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800/60">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Amount Transferred</span>
                        <div class="text-right">
                            <span class="text-lg font-black text-white font-mono">{{ number_format($data['amount'], 2) }}</span>
                            @if(isset($data['currency']) && $data['currency'] == "btc")
                                <span class="block text-xs text-amber-400 font-mono">({{ $data['btcEquivalent'] ?? '0' }} BTC)</span>
                            @elseif(isset($data['currency']) && $data['currency'] == "usdttrc20")
                                <span class="block text-xs text-emerald-400 font-mono">USDT</span>
                            @elseif(isset($data['currency']) && $data['currency'] == "eth")
                                <span class="block text-xs text-indigo-400 font-mono">ETH</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Sent From</span>
                        <span class="font-mono font-semibold text-slate-200">{{ $data['sent_from'] }}</span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Recipient</span>
                        <span class="font-mono font-semibold text-slate-200">{{ $data['sent_to'] }}</span>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-3 border-t border-slate-800/60">
                        <span class="text-slate-400">Transaction ID</span>
                        <span class="font-mono font-semibold text-primary px-2 py-0.5 bg-primary/10 rounded-md">{{ $data['transaction_id'] }}</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ url('index') }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#c59b27] hover:bg-[#b0871d] text-black text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-md">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span> Return to Client Area
                    </a>
                </div>
            @else
                <div class="text-center py-6">
                    <div class="w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[32px]">warning</span>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2">Transaction Details Unavailable</h2>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-6">
                        No active transfer session was detected. If you completed a payment, please inspect your transaction ledger.
                    </p>
                    <a href="{{ url('index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#c59b27] hover:bg-[#b0871d] text-black text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-md">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span> Return to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
