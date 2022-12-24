@extends('layout.layout')

@section('title', 'Assignments')

@section('container')
<div class="bg-white shadow">
    <div class="p-5">
        <h1 class="text-2xl text-gray-900 font-bold">Examens</h1>
    </div>
    <nav class="flex px-5 items-center gap-3 mb-4">
        <a class="px-1 py-3 text-sm transition font-medium border-b-2 @unless(request()->category) text-blue-600 border-current @else border-transparent hover:border-current text-slate-500 @endunless" href="{{ route('group.index') }}">Attribué</a>
        <a class="px-1 py-3 text-sm transition font-medium border-b-2 @if(request()->category == 'completed') text-blue-600 border-current @else border-transparent hover:border-current text-slate-500 @endunless" href="{{ request()->fullUrlWithQuery(['category' => 'completed']) }}">Complété</a>
        <a class="px-1 py-3 text-sm transition font-medium border-b-2 @if(request()->category == 'sheduled') text-blue-600 border-current @else border-transparent hover:border-current text-slate-500 @endunless" href="{{ request()->fullUrlWithQuery(['category' => 'sheduled']) }}">Programmé</a>
    </nav>
</div>
<div class="px-7">
    <div class="inline-flex items-center gap-x-3 text-slate-800 px-3 py-2 rounded-full text-xs bg-white shadow-sm border font-medium mb-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm-2 0h1v1A2.5 2.5 0 0 0 6.5 5h3A2.5 2.5 0 0 0 12 2.5v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"/>
        </svg>
        {{ $groups->count() }}
    </div>
    @if (session('success'))   
    <div class="rounded flex items-center gap-x-4 border mb-3 shadow-sm text-sm py-3 px-4 bg-green-50 text-green-600 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
        </svg>
        <div>
            {!! session('success') !!}
        </div>
    </div>
    @endif
    @forelse ($groups as $group)
        <a class="block transition duration-200 hover:shadow-md ease-in-out bg-white px-4 py-4 rounded-md border mb-3" href="{{ route('group.show', ['id' => $group->id]) }}">
            <div class="flex justify-between">
                <div>
                    <h5 class="font-medium text-sm mb-1.5">{{ $group->title }}</h5>
                    @if(auth()->user()->role == 0)
                    <div class="text-xs flex items-center font-light text-gray-600 gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                            <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                            <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
                        </svg>
                        Pr. {{ $group->user->full_name }}
                    </div>
                    @else
                    <div class="text-xs flex items-center font-light text-gray-600 gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                        </svg>
                        {{ $group->members->count() }} étudiants
                    </div>
                    @endif
                </div>
                <div>
                    @if ($group->points)<span class="text-xs text-gray-600">{{ $group->points }} points</span> @endif
                </div>
            </div>
        </a>
    @empty
    <div class="text-center py-5">
        {{-- <img class="w-36" src="{{ asset('assets/img/illustrations/not_found.svg') }}" alt=""> --}}
        <h1 class="text-2xl font-bold mb-2">Pas d'examen trouvé</h1>
        <p class="text-gray-600 text-sm">Il n'existe aucune examen dans cette examen</p>
    </div>
    @endforelse
</div>
@endsection