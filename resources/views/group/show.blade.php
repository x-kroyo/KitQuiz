@extends('layout.layout')

@section('title', 'Assignments')

@section('container')
<div class="bg-white shadow px-10 mb-5">
    <div class="py-5">
        <a class="text-sm mb-3 font-medium flex items-center gap-2 text-blue-600 hover:text-blue-800 transition" href="{{ route('group.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
            Back
        </a>
        <div class="md:flex md:justify-between md:items-start">
            <div>
                <h1 class="text-lg font-medium mb-2">{{ $group->title }}</h1>
                <p class="text-zinc-500 font-light text-sm mb-2">Due to {{ $group->due_to->format('d M Y H:i') }}@if($group->close_on) • Close at {{ $group->close_on->format('d M Y H:i') }}@endif</p>        
            </div>
            @if ($group->user_id == auth()->id())  
            <div class="flex items-center gap-x-1 mt-3 md:mt-0">
                <a class="rounded-full py-2 px-3 transition bg-slate-100 justify-center border flex items-center gap-x-2 text-slate-800 hover:bg-slate-200 text-xs font-bold" href="{{ route('group.edit', ['id' => $group->id]) }}">Modifier</a>
                <a class="rounded-full py-2 px-3 transition bg-red-600 justify-center border flex items-center gap-x-2 text-white hover:bg-red-700 text-xs font-bold" href="{{ route('group.delete', ['id' => $group->id]) }}">Supprimer</a>
            </div>
            @endif
        </div>
    </div>
    <nav class="flex items-center justify-center md:justify-start gap-x-2">
        <a class="py-3 px-2 text-sm font-medium border-b-2 @if(request()->routeIs('group.show')) border-current text-blue-600 border-b-2 @else border-transparent transition text-slate-500 hover:text-slate-700 @endif" href="{{ route('group.show', ['id' => $group->id]) }}">À propos</a>
        @if($group->user_id == auth()->id())
        <a class="py-3 px-2 text-sm font-medium border-b-2 @if(request()->routeIs('group.members')) border-current text-blue-600 border-b-2 @else border-transparent transition text-slate-500 hover:text-slate-700 @endif" href="{{ route('group.members', ['id' => $group->id]) }}">Membres</a>
        <a class="py-3 px-2 text-sm font-medium border-b-2 @if(request()->routeIs('group.answers')) border-current text-blue-600 border-b-2 @else border-transparent transition text-slate-500 hover:text-slate-700 @endif" href="{{ route('group.answers', ['id' => $group->id]) }}">Réponses</a>
        @endif
    </nav>
</div>
<div class="md:px-10 px-5">
    @yield('content')
</div>
@endsection