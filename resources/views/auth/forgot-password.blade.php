<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:linear-gradient(135deg,#fef9f0 0%,#f0fdf4 40%,#dcfce7 70%,#bbf7d0 100%)">
    <div class="w-full max-w-md fade-in">
        <div class="bg-white rounded-3xl shadow-xl p-8">
            <a href="{{ route('programs') }}" class="flex items-center gap-3 mb-8 justify-center">
                <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center"><i class="fas fa-graduation-cap text-white"></i></div>
                <span class="text-2xl font-bold text-cyan-800">Polimicro</span>
            </a>
            <div class="w-16 h-16 mx-auto rounded-2xl bg-cyan-100 flex items-center justify-center mb-6"><i class="fas fa-key text-cyan-600 text-2xl"></i></div>
            <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Lupa Password?</h1>
            <p class="text-gray-500 text-center mb-8 text-sm">Masukkan email Anda dan kami akan mengirimkan link untuk reset password</p>
            @if(session('success'))
                <div class="mb-4 p-4 bg-cyan-50 border border-cyan-200 rounded-xl text-cyan-600 text-sm">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('forgot-password') }}" class="space-y-5">
                @csrf
                <div><label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative"><i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" required placeholder="nama@polimicro.ac.id" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-white transition"></div>
                </div>
                <button type="submit" class="w-full py-3.5 btn-primary text-white rounded-xl font-semibold"><i class="fas fa-paper-plane mr-2"></i>Kirim Link Reset</button>
            </form>
            <p class="text-center text-gray-500 mt-6 text-sm">Kembali ke <a href="{{ route('login') }}" class="text-cyan-600 font-semibold">halaman login</a></p>
        </div>
    </div>
</body>
</html>
