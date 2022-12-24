@extends('layout.master')

@section('title', '404')

@section('body')
<div class="min-h-screen p-5 flex flex-col items-center justify-center gap-6">
    <div class="text-8xl font-bold">404</div>
    <div class="text-center">
        <h1 class="font-bold text-2xl mb-1">Page introuvable</h1>
        <p class="text-sm text-slate-600">La page que vous recherchez n'a pu être trouvée</p>
    </div>
    <div class="flex items-center gap-x-3">
        <a class="rounded px-5 py-2 bg-blue-600 hover:bg-blue-800 text-white border border-blue-600 transition font-medium text-sm" href="{{ route('home') }}">Page d'accueil</a>
        <a class="rounded px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 border font-medium transition text-sm" href="{{ url()->previous() }}">Page précédance</a>
    </div>
</div>
@endsection