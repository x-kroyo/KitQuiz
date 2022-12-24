@extends('layout.master')

@section('title', 'Login')

@section('body')
<div class="grid md:grid-cols-2 grid-cols-1 min-h-screen">
    <div class="hidden h-full bg-white md:flex items-center flex-col gap-3 justify-center">
        <img class="h-24 mb-4" src="{{ asset('assets/img/fstbm.png') }}" alt="Faculté des Sciences et Techniques - Beni Mellal">
        <h3 class="text-3xl font-bold">Platform d'examen en ligne</h3>
        <p class="text-gray-600">Faculté des Sciences et Techniques - Beni Mellal</p>
    </div>
    <div class="h-full flex bg-white items-center justify-center">
        <div class="md:w-9/12 px-5 py-5 md:py-0">
            <div class="flex items-center gap-x-3 mb-5 md:hidden">
                <img class="h-12" src="{{ asset('assets/img/fstbm.png') }}" alt="Faculté des Sciences et Techniques - Beni Mellal">
                <div>
                    <h6 class="font-medium">Platform d'examen en ligne</h6>
                    <p class="text-sm text-gray-600">Faculté des Sciences et Techniques - Beni Mellal</p>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-10">Créer votre compte sur la platforme</h3>
            <form action="{{ route('user.create') }}" method="post">
                @csrf
                <div class="grid grid-cols-2 gap-x-4">
                    <div class="form-group mb-3">
                        <label for="first_name">Prénom</label>
                        <input class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('first_name') border-red-600 @enderror" type="text" name="first_name" value="{{ old('first_name') }}" id="first_name">
                        @error('first_name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="last_name">Nom</label>
                        <input class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('last_name') border-red-600 @enderror" type="text" name="last_name" value="{{ old('last_name') }}" id="last_name">
                        @error('last_name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>    
                </div>
                <div class="form-group mb-3">
                    <label for="email">Adresse email</label>
                    <input class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('email') border-red-600 @enderror" type="email" name="email" value="{{ old('email') }}" id="email">
                    @error('email')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password">Mot de passe</label>
                    <input class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('password') border-red-600 @enderror" type="password" name="password" id="password">
                    @error('password')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-5">
                    <label for="role">Je suis</label>
                    <select class="rounded focus:ring ring-blue-600 transition block w-full border outline-none py-2 px-2.5 @error('role') border-red-600 @enderror" name="role" id="role">
                        <option value="0" @selected(!old('role'))>Etudiant</option>
                        <option value="1" @selected(old('role'))>Professeur</option>
                    </select>
                    @error('role')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 py-2.5 text-sm font-bold rounded w-full transition text-white px-6">Crée un compte</button>
                <div class="border text-sm rounded text-center mt-4 py-4 px-3">
                    Vous avez déja un compte ? <a class="text-blue-600 font-bold hover:text-blue-800" href="{{ route('login') }}">Connectez-vous</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection