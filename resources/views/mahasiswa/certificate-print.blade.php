<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kelulusan - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background-color: #f8fafc; }
        .certificate-container {
            width: 1056px; /* 11in at 96dpi */
            height: 816px; /* 8.5in at 96dpi */
            margin: 2rem auto;
            background: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .font-cursive { font-family: 'Great Vibes', cursive; }
        
        /* Shape Styles */
        .bg-shapes {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        @media print {
            html, body { 
                background: white; 
                margin: 0; 
                padding: 0; 
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            .certificate-container { 
                margin: 0; 
                box-shadow: none; 
                width: 100%; 
                height: 100%;
                max-width: 100vw;
                max-height: 100vh;
                page-break-inside: avoid;
                page-break-after: avoid;
                page-break-before: avoid;
                transform: scale(1);
                transform-origin: top left;
            }
            .no-print { display: none !important; }
            @@page {
                size: landscape;
                margin: 0mm;
            }
        }
    </style>
</head>
<body class="text-slate-800">

    <div class="text-center py-6 no-print bg-slate-900 border-b-4 border-cyan-500 mb-8">
        <h2 class="text-xl font-bold text-white mb-4">Preview Sertifikat</h2>
        <button onclick="window.print()" class="px-8 py-3 bg-cyan-500 text-white rounded-full font-bold shadow-lg hover:bg-cyan-400 transition hover:scale-105 active:scale-95">
            <i class="fas fa-print mr-2"></i> Cetak / Simpan PDF
        </button>
        <p class="text-slate-400 text-sm mt-3">Gunakan setting <strong>Landscape</strong> & hapus centang <strong>Headers and Footers</strong></p>
    </div>

    <div class="certificate-container">
        
        <!-- Vector Background -->
        <svg class="bg-shapes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1056 816" preserveAspectRatio="none">
            <!-- Top Right Geometric -->
            <polygon points="650,0 1056,0 1056,400" fill="#1e293b" />
            <polygon points="800,0 1056,0 1056,250" fill="#f1f5f9" />
            
            <!-- Bottom Left Geometric -->
            <polygon points="0,400 0,816 416,816" fill="#f1f5f9" />
            <polygon points="0,550 0,816 266,816" fill="#1e293b" />
            <!-- Small accent triangle -->
            <polygon points="150,816 350,816 250,716" fill="#1e293b" opacity="0.9" />
            
            <!-- Double Border -->
            <rect x="40" y="40" width="976" height="736" fill="none" stroke="#0891b2" stroke-width="4" />
            <rect x="48" y="48" width="960" height="720" fill="none" stroke="#0891b2" stroke-width="1" />
            
            <!-- Horizontal Cyan Bar left of 'Kelulusan' -->
            <rect x="0" y="244" width="390" height="18" fill="#0891b2" />
        </svg>
        
        <!-- Ribbon at Top Right -->
        <div class="absolute top-10 right-36 w-24 h-48 bg-gradient-to-br from-cyan-400 to-cyan-600 z-10 shadow-xl" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 80%, 0 100%);"></div>

        <!-- Content -->
        <div class="relative z-20 w-full h-full flex flex-col items-center justify-start pt-32">
            
            <h1 class="text-6xl font-extrabold tracking-[0.25em] text-slate-800 mb-4 ml-[0.25em]">SERTIFIKAT</h1>
            
            <div class="flex items-center w-full mb-16">
                <!-- Spacing equivalent to the cyan bar -->
                <div style="width: 410px;"></div>
                <h2 class="text-2xl font-bold tracking-[0.3em] text-cyan-600 uppercase ml-2">Kelulusan</h2>
            </div>
            
            <div class="text-center mt-6 w-full max-w-3xl">
                <p class="text-sm font-semibold tracking-[0.2em] text-slate-600 uppercase mb-8 italic">
                    Dengan Bangga Diberikan Kepada:
                </p>
                
                <h2 class="text-[5.5rem] leading-none font-cursive text-cyan-700 mb-8 px-12 drop-shadow-sm" style="text-shadow: 1px 1px 0px rgba(8, 145, 178, 0.2);">
                    {{ $user->name }}
                </h2>
                
                <p class="text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto font-medium">
                    telah berhasil menyelesaikan program studi microcredential dengan memuaskan dalam bidang 
                    <strong class="text-slate-800 font-bold">{{ $sertifikat->prodi->nama_prodi ?? 'Program' }}</strong> 
                    yang diselenggarakan oleh Polimicro<br>pada tanggal {{ $sertifikat->tanggal_terbit->translatedFormat('d F Y') }}
                </p>
            </div>
            
            <div class="absolute bottom-24 w-full flex justify-center mt-8">
                <div class="text-center border-t border-slate-400 pt-4 px-12">
                    <p class="text-base font-extrabold tracking-[0.1em] text-slate-800 uppercase">Direktur Program</p>
                    <p class="text-xs text-slate-500 font-bold tracking-widest mt-2 uppercase">No: {{ $sertifikat->nomor_sertifikat }}</p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
