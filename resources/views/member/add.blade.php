@extends('layout.layout')

@section('title', 'Rejoidre un examen')

@section('container')
<div class="px-10 pt-10">
    <div class="text-center mb-7">
        <h4 class="text-3xl font-bold mb-2">Rejoidre un examen</h4>
        <p>Voici saisir ci-dessous le code de l'examen donné par le résponsable d'examen</p>
    </div>
    <form action="{{ route('group.member.store') }}" method="POST">
        @csrf
        @if (session('info'))   
        <div class="rounded flex items-center justify-between gap-x-4 border mb-3 shadow-sm text-sm py-3 px-4 bg-sky-50 text-sky-600 font-medium">
            <div class="flex items-center gap-x-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <div>
                    {!! session('info') !!}
                </div>
            </div>
            <button class="cursor-pointer text-slate-600 hover:text-slate-800" onclick="this.parentNode.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                </svg>
            </button>
        </div>
        @endif
        <label for="code">Code d'examen</label>
        <input name="code" class="rounded outline-none text-xl mb-2 py-2 px-3 bg-white focus:bg-white border focus:ring-2 ring-blue-500 block w-full @error('code') border border-red-600 @enderror" type="text">
        @error('code')
        <p class="text-red-600">{{ $message }}</p>
        @enderror
        <div class="flex justify-end">
            <button type="submit" class="rounded md:w-auto w-full px-5 py-2 text-white bg-blue-600 hover:bg-blue-800">Rejoindre</button>
        </div>
    </form>
</div>
@endsection