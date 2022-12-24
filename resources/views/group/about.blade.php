@extends('group.show')

@section('title', $group->title)

@section('content')
<div class="grid gap-x-6 md:grid-cols-11 grid-cols-1">
    <div class="md:col-span-7">
        @if (now()->gte($group->start_at))   
            <div class="bg-white rounded-lg border mb-5">
                <h6 class="text-sm pt-4 px-5 font-bold">Instructions</h6>
                <p class="text-sm py-4 px-5">
                    @empty($group->instructions)
                    <span class="text-gray-600 text-sm">Liste des instructions est vide</span>
                    @else
                    {!! nl2br($group->instructions) !!}
                    @endEmpty
                </p>
            </div>
            <div class="bg-white rounded-lg border mb-5">
                <h6 class="text-sm pt-4 pb-3 px-5 font-bold">Reference materials</h6>
                @forelse ($group->files as $file)
                <a class="flex px-5 py-2.5 gap-x-4 border-b last:border-0 items-center hover:bg-slate-50 transition" href="{{ route('group.attachment.download', ['id' => $group->id, 'attachment' => $file->id]) }}" target="_blank">
                    <img class="w-5 h-5" src="{{ asset('assets/img/extensions/' . $file->extension . '.png') }}" alt="">
                    <div>
                        <h6 class="truncate text-xs font-medium">{{ $file->file_name }}</h6>
                        <p class="text-gray-600 text-xs">{{ 'PDF document' }}</p>
                    </div>
                </a>
                @empty
                <p class="text-sm text-center text-gray-600 px-5 py-2.5">Aucune référence a été ajouté</p>
                @endforelse
            </div>
            @if (session('success'))    
            <div class="rounded flex items-center gap-x-4 border mb-3 shadow-sm text-sm py-3.5 px-4 bg-green-50 text-green-600 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if (session('closed'))    
            <div class="rounded flex items-center gap-x-4 border mb-3 shadow-sm text-sm py-3.5 px-4 bg-red-50 text-red-600 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard2-x" viewBox="0 0 16 16">
                    <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"/>
                    <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"/>
                    <path d="M8 8.293 6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293Z"/>
                </svg>
                {{ session('closed') }}
            </div>
            @endif
            @empty (auth()->user()->role)                
            <div class="bg-white rounded-lg border mb-5">
                @if ($answer)
                    <div class="py-4 px-5 md:flex justify-between items-center">
                        <div>
                            <h6 class="font-bold text-sm mb-1">Mon travail</h6>
                            <div class="text-blue-600 font-medium flex items-center text-xs mb-1 gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                                Rendu à {{ $answer->created_at->format('d M Y h:i a') }}
                            </div>
                        </div>
                        @unless ($closed)
                        <a href="{{ route('group.answer.delete', ['id' => $group->id]) }}" class="block md:inline text-center mt-3 md:mt-0 text-slate-800 border border-slate-300 bg-slate-50 hover:bg-slate-200 transition py-2 px-4 rounded text-sm font-medium">Annuler</a>
                        @endunless
                    </div>
                    @foreach ($answer->files as $file)
                    <a class="flex px-5 py-2 gap-x-4 items-center hover:bg-slate-50 transition" href="#">
                        <img class="w-5 h-5" src="{{ asset('assets/img/extensions/' . $file->extension . '.png') }}" alt="">
                        <div>
                            <h6 class="truncate text-xs font-medium">{{ $file->file_name }}</h6>
                            <p class="text-gray-600 text-xs">{{ 'PDF document' }}</p>
                        </div>
                        {{-- <div class="self-"></div> --}}
                    </a>
                    @endforeach
                @elseif($closed)
                    <div class="text-center py-9 px-5">
                        <div class="flex items-center bg-red-50 shadow rounded-full text-red-600 justify-center w-16 h-16 mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-clipboard2-x-fill" viewBox="0 0 16 16">
                                <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z"/>
                                <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5ZM8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 1 1 .708-.708L8 8.293Z"/>
                            </svg>
                        </div>
                        <h5 class="font-medium text-xl text-red-600 mb-1">Exam closed</h5>
                        <p class="text-sm text-gray-600">La date d'ajout est echoué</p>

                    </div>
                @else
                    <form enctype="multipart/form-data" action="{{ route('group.answer', ['id' => $group->id]) }}" method="post">
                        @csrf
                        <div class="py-4 px-5 md:flex justify-between items-center">
                            <div>
                                <h6 class="font-bold text-sm mb-1">Mon travail</h6>
                                <p class="text-xs text-gray-600">Ajouter votre travail d'examen</p>
                            </div>
                            <button type="submit" class="w-full md:w-auto block md:inline text-center mt-3 md:mt-0 text-white bg-blue-600 hover:bg-blue-800 transition py-2 px-5 rounded shadow-sm text-sm font-medium">Rendre</button>
                        </div>
                        <div class="py-4 px-5">
                            <input class="mb-4" type="file" name="attachments[]" multiple>
                            @foreach ($errors->all() as $error)
                            <p class="text-red-600 font-medium text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </form>
                @endif
                
            </div>
            @endEmpty
        @else
            <div class="bg-white rounded-lg py-6 px-5 border mb-5 text-center">
                <h6 class="font-bold mb-1 text-lg">Pas encore commencé</h6>
                <p class="text-sm text-gray-600">L'examen sera commencé à {{ $group->start_at->format('d M Y H:i') }}</p>
            </div>
        @endif
    </div>
    <div class="md:col-span-4">
        <div class="bg-white p-4 px-5 rounded-lg border mb-5">
            <h5 class="mb-1 font-bold text-sm">Points</h5>
            <p class="text-gray-600 text-sm">{{ $group->points ? $group->points . ' points' : 'No points' }}</p>
        </div>
        @if (auth()->id() == $group->user_id)
        <div class="bg-white p-4 px-5 rounded-lg border mb-5">
            <h5 class="mb-1 font-bold text-sm">Code d'examen</h5>
            <p class="text-blue-600 text-md">{{ $group->code }}</p>
        </div>
        @endif
    </div>
</div>
@endsection