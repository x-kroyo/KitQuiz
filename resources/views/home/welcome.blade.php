@extends('layout.master', ['body' => 'bg-white'])

@section('body')
<div class="min-h-screen md:w-8/12 md:mx-auto p-5 flex flex-col items-center justify-center gap-6">
    <img src="{{ asset('assets/img/fstbm.png') }}" alt="FSTBM">
    <div class="text-center">
        <h1 class="font-bold text-blue-600 text-2xl mb-2">Bienvenue à notre platforme d'examen en ligne</h1>
        <p class="font-light text-slate-600">La platforme de la faculté des Sciences et Techniques - Beni Mellal pour passer votre examens en ligne avec votre enseignants ou étudiants</p>
    </div>
    <p>Connectez-vous à notre platforme</p>
    <div class="w-full md:w-auto flex flex-col md:flex-row items-center gap-y-1 gap-x-5">
        <a class="w-full md:w-auto text-center rounded px-5 py-2 bg-blue-600 hover:bg-blue-800 text-white border border-blue-600 transition font-medium text-sm" href="{{ route('login') }}">Se Connecter à votre compte</a>
        <span>ou</span>
        <a class="w-full md:w-auto text-center rounded px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 border font-medium transition text-sm" href="{{ route('signup') }}">Créer un compte</a>
    </div>
</div>
@endsection