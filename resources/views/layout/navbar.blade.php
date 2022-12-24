<nav class="px-5 py-2.5 fixed top-0 left-0 w-full flex items-center justify-between bg-white border-b z-50">
    <a class="flex items-center gap-x-3" href="{{ route('home') }}">
        <img class="h-8" src="{{ asset('assets/img/fstbm.png') }}" alt="Faculté des Sciences et Techniques - Beni Mellal">
        <div>
            <h6 class="text-sm font-medium">Platform d'examen en ligne</h6>
            <p class="text-xs text-gray-600">Faculté des Sciences et Techniques - Beni Mellal</p>
        </div>
    </a>
    <div class="flex items-center gap-x-7">
        <a class="text-sm font-bold text-blue-600 hover:text-blue-800" href="{{ route('logout') }}">Se déconnecter</a>
    </div>
</nav>