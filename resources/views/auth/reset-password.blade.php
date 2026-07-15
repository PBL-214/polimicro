<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-slate-50 dark:bg-slate-900 transition-colors">
    <div class="w-full max-w-md fade-in">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none p-8 border border-slate-100 dark:border-slate-700">
            <a href="{{ route('programs') }}" class="flex items-center gap-3 mb-8 justify-center">
                <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center"><i class="fas fa-graduation-cap text-white"></i></div>
                <span class="text-2xl font-bold text-cyan-800 dark:text-white">Polimicro</span>
            </a>
            <div class="w-16 h-16 mx-auto rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center mb-6"><i class="fas fa-lock text-cyan-600 dark:text-cyan-400 text-2xl"></i></div>
            <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-2">Reset Password</h1>
            <p class="text-gray-500 dark:text-gray-400 text-center mb-8 text-sm">Masukkan password baru untuk akun Anda.</p>
            
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl text-red-600 dark:text-red-400 text-sm">{{ $errors->first() }}</div>
            @endif
            
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <div class="relative"><i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 focus:outline-none"></div>
                </div>
                
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                    <div class="relative"><i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white transition focus:ring-2 focus:ring-cyan-500"></div>
                </div>

                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
                    <div class="relative"><i class="fas fa-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password baru" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white transition focus:ring-2 focus:ring-cyan-500"></div>
                </div>
                
                <button type="submit" class="w-full py-3.5 btn-primary text-white rounded-xl font-semibold"><i class="fas fa-save mr-2"></i>Simpan Password Baru</button>
            </form>
        </div>
    </div>
</body>
</html>
