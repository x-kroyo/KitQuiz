@extends('group.show')

@section('title', 'Members - ' . $group->title)

@section('content')
<div class="inline-flex items-center gap-x-3 text-slate-800 px-3 py-2 rounded-full text-xs bg-white shadow-sm border font-medium mb-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
    </svg>
    {{ number_format($group->members->count()) }}
</div>
@if(session('success'))
<div class="rounded-md bg-green-50 border text-green-600 font-bold text-sm px-3 py-3 gap-x-3 flex items-center justify-between mb-3">
    <div class="flex items-center gap-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    <button class="text-slate-600 cursor-pointer transition hover:text-slate-900" onclick="this.parentNode.remove()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
        </svg>
    </button>
</div>
@endif
@if (auth()->user()->role == 0)
<div class="rounded-lg border mb-3 bg-white px-3 py-2.5 shadow-sm">
    <h6 class="font-bold text-sm mb-1.5">Responsable</h6>
    <div class="flex items-center gap-x-4">
        <div class="flex items-center text-xs gap-x-2 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"></path>
            </svg>
            Pr. {{ $group->user->full_name }}
        </div>
        <div class="flex items-center text-xs gap-x-2 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-at" viewBox="0 0 16 16">
                <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"/>
            </svg>
            {{ $group->user->email }}
        </div>
    </div>
</div>
@endif
<div class="w-full bg-white rounded-lg border text-left mb-5">
    <div class="grid grid-cols-12 px-4 text-sm py-3 border-b">
        <div class="col-span-1">
            <h6 class="font-bold">N°</h6>
        </div>
        <div class="col-span-4">
            <h6 class="font-bold">Nom & Prénom</h6>
        </div>
        <div class="col-span-7">
            <h6 class="font-bold">E-mail</h6>
        </div>
    </div>
    @forelse ($members as $key => $member)
    <div class="grid grid-cols-12 px-4 text-sm py-3 border-b last:border-0 even:bg-gray-50">
        <div class="col-span-1">
            <h6 class="font-bold">{{ $key + 1 }}</h6>
        </div>
        <div class="col-span-4">{{ $member->full_name }}</div>
        <div class="col-span-6">{{ $member->email }}</div>
        @if ($group->user_id == auth()->id())
        <div class="col-span-1">
            <div class="flex justify-end">
                <a class="text-xs font-bold text-blue-600 hover:text-blue-800 transition" href="{{ route('group.members.delete', ['id' => $group->id, 'member' => $member->id]) }}">Supprimer</a>
            </div>
        </div>
        @endif
    </div>
    @empty
    <div class="py-7 text-center">
        <h5 class="font-bold mb-1">No members to show</h5>
        <p class="text-sm text-slate-600">There no members to display for you</p>
    </div>    
    @endforelse
</div>
{{ $members->links('layout.paginate') }}
@endsection