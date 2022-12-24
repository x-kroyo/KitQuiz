@extends('layout.master')

@section('title', 'Connecter-vous')

@section('body')
<div class="grid md:grid-cols-2 grid-cols-1 min-h-screen">
    <div class="hidden h-full md:flex items-center bg-conver bg-center bg-no-repeat justify-center" style="background-image: url('{{ asset('assets/img/wallpapers/desktop.jpg') }}')"></div>
    <div class="h-full flex bg-white items-center justify-center">
        <div class="md:w-9/12">
            <div class="flex items-center gap-x-3 mb-5">
                <img class="h-12" src="{{ asset('assets/img/fstbm.png') }}" alt="Faculté des Sciences et Techniques - Beni Mellal">
                <div>
                    <h6 class="font-medium">Platform d'examen en ligne</h6>
                    <p class="text-sm text-gray-600">Faculté des Sciences et Techniques - Beni Mellal</p>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-10">Connectez-vous à votre compte</h3>
            <form action="{{ route('auth') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Address email</label>
                    <input class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('email') border-red-600 @enderror" type="email" name="email" value="{{ old('email') }}" id="email">
                    @error('email')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Mot de pass</label>
                    <input class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('password') border-red-600 @enderror" type="password" name="password" id="password">
                    @error('password')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 py-2.5 text-sm font-bold rounded w-full transition text-white px-6">Log in</button>
                <div class="border text-sm rounded text-center mt-4 py-4 px-3">
                    Vous n'avez pas de compte ? <a class="text-blue-600 font-bold hover:text-blue-800" href="{{ route('signup') }}">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection