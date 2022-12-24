@extends('layout.layout')

@section('container')
<div class="md:w-9/12 md:mx-auto p-10">
    <img class="h-24 mx-auto mb-9" src="{{ asset('assets/img/fstbm2.png') }}" alt="FSTBM">
    <div class="text-center mb-9">
        <h1 class="font-bold text-2xl mb-4">Bonjour, @if(auth()->user()->role)Pr.@endif {{ auth()->user()->full_name }}</h1>
        <p class="font-light text-slate-600">Bienvenue à la platforme de la faculté des Sciences et Techniques - Beni Mellal pour passer ou gérer votre examens en ligne avec votre enseignants ou étudiants</p>
    </div>
    <div class="flex justify-center">
        @if (auth()->user()->role)
        <a class="rounded-md bg-blue-600 hover:bg-blue-800 transition flex gap-x-2 items-center mb-4 text-white block py-2 px-5 text-sm font-medium justify-center" href="{{ route('group.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-plus-fill" viewBox="0 0 16 16">
                <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm4.5 6V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5a.5.5 0 0 1 1 0Z"/>
            </svg>
            Créer un examen
        </a>
        @else
        <a class="rounded-md bg-blue-600 hover:bg-blue-800 transition flex gap-x-2 items-center mb-4 text-white block py-2 px-5 text-sm font-medium justify-center" href="{{ route('group.member.add') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
            </svg>
            Rejoindre un examen
        </a>
        @endif
    </div>
</div>
@endsection