<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Lora', serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cyan-500 flex items-center justify-center shadow-lg shadow-cyan-500/20"><i class="fas fa-graduation-cap text-sm text-white"></i></div>
                    <span class="font-bold text-xl text-slate-800 font-serif tracking-tight">Polimicro</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Verifikasi Sertifikat</h2>
                <p class="mt-2 text-sm text-slate-500">Hasil pengecekan keaslian sertifikat kelulusan.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100 relative">
                
                @if($sertifikat)
                    <!-- Valid Status Header -->
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-8 text-center text-white relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-10">
                            <i class="fas fa-check-circle text-9xl"></i>
                        </div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 backdrop-blur-sm border border-white/30 shadow-inner">
                                <i class="fas fa-check text-3xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold tracking-tight">Sertifikat Valid</h3>
                            <p class="text-emerald-100 mt-1 text-sm">Dokumen ini resmi dan terdaftar di sistem Polimicro.</p>
                        </div>
                    </div>

                    <!-- Certificate Details -->
                    <div class="p-8 space-y-6">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Diberikan Kepada</p>
                            <p class="text-lg font-bold text-slate-900">{{ $sertifikat->mahasiswa->name }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Program Studi</p>
                                <p class="text-sm font-bold text-slate-800">{{ $sertifikat->prodi->nama_prodi ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Terbit</p>
                                <p class="text-sm font-bold text-slate-800">{{ $sertifikat->tanggal_terbit->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nomor Sertifikat</p>
                            <p class="font-mono text-sm font-bold text-slate-700 bg-slate-50 p-3 rounded-lg border border-slate-100">{{ $sertifikat->nomor_sertifikat }}</p>
                        </div>
                    </div>
                @else
                    <!-- Invalid Status Header -->
                    <div class="bg-gradient-to-br from-red-500 to-rose-600 p-8 text-center text-white relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-10">
                            <i class="fas fa-times-circle text-9xl"></i>
                        </div>
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4 backdrop-blur-sm border border-white/30 shadow-inner">
                                <i class="fas fa-times text-3xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold tracking-tight">Tidak Ditemukan</h3>
                            <p class="text-red-100 mt-1 text-sm">Sertifikat ini tidak terdaftar di sistem kami.</p>
                        </div>
                    </div>

                    <!-- Invalid Details -->
                    <div class="p-8 text-center space-y-4">
                        <p class="text-slate-600 text-sm">Kami tidak dapat menemukan data sertifikat dengan nomor yang Anda masukkan. Pastikan nomor atau QR Code yang Anda scan benar.</p>
                        
                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nomor yang dicari</p>
                            <p class="font-mono text-sm font-bold text-red-600 bg-red-50 p-3 rounded-lg border border-red-100 inline-block">{{ $nomor_sertifikat }}</p>
                        </div>
                    </div>
                @endif
                
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-cyan-600 hover:text-cyan-700 transition"><i class="fas fa-home mr-1"></i> Kembali ke Beranda</a>
            </div>

        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Polimicro. All rights reserved.</p>
    </footer>

</body>
</html>
