@extends('group.show')

@section('title', 'Réponces - ' . $group->title)

@section('content')
<div class="grid md:grid-cols-4 grid-cols-3 md:gap-4 gap-2.5 mb-5">
    @php($total = $group->answers->count())
    <div class="rounded-lg text-green-600 border-b-2 border-b-current relative px-5 py-4 bg-white shadow-sm border">
        <h1 class="text-xl font-bold mb-1">{{ number_format($total) }}</h1>
        <p class="text-xs font-bold">{{ $total ? 'Copies rendu au total' : 'Aucune copie rendu' }}</p>
    </div>
    @php($miss = max($group->members->count() - $total, 0))
    <div class="rounded-lg text-red-600 border-b-2 border-b-current relative px-5 py-4 bg-white shadow-sm border">
        <h1 class="text-xl font-bold mb-1">{{ number_format($miss) }}</h1>
        <p class="text-xs font-bold">{{ $miss ? 'En attend des copies' : 'Toutes les copies sont rendu' }}</p>
    </div>
    @php($retard = $answers->where('created_at', '>=', $group->due_to)->count())
    <div class="rounded-lg text-cyan-600 border-b-2 border-b-current relative px-5 py-4 bg-white shadow-sm border">
        <h1 class="text-xl font-bold mb-1">{{ number_format($retard) }}</h1>
        <p class="text-xs font-bold">{{ $retard ? 'Retard effectuée' : 'Aucune retard effectuée' }}</p>
    </div>
</div>
<div class="w-full bg-white rounded-lg border text-left mb-5">
    <div class="grid grid-cols-12 px-4 text-sm py-3 border-b">
        <div class="col-span-1">
            <h6 class="font-bold">N°</h6>
        </div>
        <div class="col-span-4">
            <h6 class="font-bold">Nom d'étudiant</h6>
        </div>
        <div class="col-span-4">
            <h6 class="font-bold">Date de rendu</h6>
        </div>
        <div class="col-span-3">
            <h6 class="font-bold">Fichiers</h6>
        </div>
    </div>
    @forelse ($answers as $answer)
    <div class="grid grid-cols-12 px-4 items-center py-2 border-b last:border-0 odd:bg-gray-50">
        <div class="col-span-1">
            <h6 class="font-bold text-sm">{{ $answer->id }}</h6>
        </div>
        <div class="col-span-4">
            <div class="flex items-center gap-x-3.5">
                <div class="rounded-full shadow border border-gray-300 h-8 w-8 flex items-center justify-center font-bold text-xs bg-slate-100 text-slate-800">{{ $answer->user->short_name }}</div>
                <h6 class="font-medium text-sm">{{ $answer->user->full_name }}</h6>
            </div>
        </div>
        <div class="col-span-3">
            <p class="text-sm">{{ $answer->created_at->format('d M Y h:i A') }}</p>            
        </div>
        <div class="col-span-1">
            @if ($answer->created_at->gt($group->due_to))
            <div class="font-bold text-xs text-red-600">• En retard</div>
            @endif
        </div>
        <div class="col-span-2">
            <p class="text-sm">{{ $answer->files->count() }} fichiers</p>
        </div>
        <div class="col-span-1">
            <div class="flex justify-end">
                <a class="rounded-full w-9 h-9 text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition flex items-center justify-center" href="{{ route('group.answer.download', ['id' => $group->id, 'answer' => $answer->id]) }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="py-7 text-center">
        <h5 class="font-bold mb-1">No answers to show</h5>
        <p class="text-sm text-slate-600">There no members to display for you</p>
    </div>
    @endforelse
</div>
{{ $answers->links('layout.paginate') }}
@endsection