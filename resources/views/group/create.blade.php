@extends('layout.layout', ['body' => 'bg-white'])

@section('title', 'Ajouter un examen')

@section('container')
<div class="px-10 pt-10">
    <form enctype="multipart/form-data" action="{{ route('group.store') }}" method="post">
        @csrf
        <div class="flex items-center justify-between mb-5">
            <h1 class="text-xl font-bold">Ajouter un examen</h1>
            <div class="flex items-center gap-x-3">
                <a href="{{ route('group.index') }}" class="font-medium transition py-2 px-5 bg-gray-100 rounded hover:bg-gray-200 text-sm">Annuler</a>
                <button type="submit" class="font-medium transition py-2 px-5 text-white rounded bg-blue-600 hover:bg-blue-800 text-sm">Ajouter</button>
            </div>
        </div>
        <div class="form-group mb-5">
            <label class="text-sm" for="title">Titre (obligatoire)</label>
            <input id="title" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-500 block w-full @error('title') border border-red-600 @enderror outline-none py-1.5 px-2.5 @error('title') border-red-600 @enderror" type="text" name="title" value="{{ old('title') }}">
            @error('title')
            <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>
        <div class="grid grid-cols-12 gap-10">
            <div class="col-span-8">
                <div class="form-group mb-6">
                    <label class="text-sm" for="instructions">Instructions</label>
                    <textarea class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-500 block mb-3 w-full @error('instructions') border border-red-600 @enderror outline-none py-1.5 px-2.5 @error('instructions') border-red-600 @enderror" name="instructions" id="instructions" rows="5">{{ old('instructions') }}</textarea>
                    @error('instructions')
                    <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-8">
                    <div class="flex gap-x-4 mb-4">
                        <svg class="mt-1 text-slate-700" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-month" viewBox="0 0 16 16">
                            <path d="M2.56 11.332 3.1 9.73h1.984l.54 1.602h.718L4.444 6h-.696L1.85 11.332h.71zm1.544-4.527L4.9 9.18H3.284l.8-2.375h.02zm5.746.422h-.676V9.77c0 .652-.414 1.023-1.004 1.023-.539 0-.98-.246-.98-1.012V7.227h-.676v2.746c0 .941.606 1.425 1.453 1.425.656 0 1.043-.28 1.188-.605h.027v.539h.668V7.227zm2.258 5.046c-.563 0-.91-.304-.985-.636h-.687c.094.683.625 1.199 1.668 1.199.93 0 1.746-.527 1.746-1.578V7.227h-.649v.578h-.019c-.191-.348-.637-.64-1.195-.64-.965 0-1.64.679-1.64 1.886v.34c0 1.23.683 1.902 1.64 1.902.558 0 1.008-.293 1.172-.648h.02v.605c0 .645-.423 1.023-1.071 1.023zm.008-4.53c.648 0 1.062.527 1.062 1.359v.253c0 .848-.39 1.364-1.062 1.364-.692 0-1.098-.512-1.098-1.364v-.253c0-.868.406-1.36 1.098-1.36z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        <div>
                            <h6 class="font-bold text-sm">Date de publication</h6>
                            <p class="text-xs text-zinc-500">Date d'échance d'examen, les copies sont acceptable en retard</small>
                        </div>
                    </div>
                    <div class="flex items-center hover:bg-slate-200 transition rounded-md bg-slate-100 py-2 px-3 gap-x-3 mb-3">
                        <input class="h-5 w-5 custom-radio bg-white focus:border-blue-600 transition checked:border-blue-600 bg-contain rounded-full border border-slate-300 appearance-none" type="radio" value="0" name="publish" id="publish-now" onchange="hideSheduleSection()" @checked(!old('publish'))>
                        <label class="w-full grow-1 mb-0" for="publish-now">
                            <h6 class="font-medium text-sm">Maintenant</h6>
                            <p class="text-gray-600 text-xs">Publier l'examen au moment d'envoie des informations</p>
                        </label>
                    </div>
                    <div class="flex items-center hover:bg-slate-200 transition rounded-md bg-slate-100 py-2 px-3 gap-x-3 mb-4">
                        <input class="h-5 w-5 custom-radio bg-white focus:border-blue-600 transition checked:border-blue-600 bg-contain rounded-full border border-slate-300 appearance-none" type="radio" value="1" name="publish" onchange="showSheduleSection()" id="publish-later" @checked(old('publish'))>
                        <label class="w-full grow-1 mb-0" for="publish-later">
                            <h6 class="font-medium text-sm">Choisir un date</h6>
                            <p class="text-gray-600 text-xs">Programmer un date pour publier l'examen, il sera afficher au étudiants ajoutés</p>
                        </label>
                    </div>
                    <div id="shedule" class="@if(!old('publish')) hidden @endif">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="form-group">
                                <label class="text-sm" for="due_to_date">Date</label>
                                <input id="shedule_date" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full @error('shedule_date') border border-red-600 ring-red-600 @enderror outline-none py-1.5 px-2.5" type="date" name="shedule_date" value="{{ old('shedule_date') }}">
                                @error('shedule_date')
                                <small class="text-red-600">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="text-sm" for="due_to_time">Temps</label>
                                <input id="shedule_time" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full @error('shedule_time') border border-red-600 ring-red-600 @enderror outline-none py-1.5 px-2.5" type="time" name="shedule_time" value="{{ old('shedule_time') }}">
                                @error('shedule_time')
                                <small class="text-red-600">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        @error('publish_date')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-8">
                    <div class="flex gap-x-4 mb-4">
                        <svg class="mt-1 text-slate-700" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-minus" viewBox="0 0 16 16">
                            <path d="M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        <div>
                            <h6 class="font-bold text-sm">Date de termination</h6>
                            <p class="text-xs text-zinc-500">Date d'échance d'examen, les copies sont acceptable en retard</small>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="form-group">
                            <label class="text-sm" for="due_to_date">Date de termination</label>
                            <input id="due_to_date" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full @error('due_to_date') border border-red-600 ring-red-600 @enderror outline-none py-1.5 px-2.5" type="date" name="due_to_date" value="{{ old('due_to_date') }}">
                            @error('due_to_date')
                            <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-sm" for="due_to_time">Temps de termination</label>
                            <input id="due_to_time" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full @error('due_to_time') border border-red-600 ring-red-600 @enderror outline-none py-1.5 px-2.5" type="time" name="due_to_time" value="{{ old('due_to_time') }}">
                            @error('due_to_time')
                            <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @error('due_date')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                    <div class="mt-4 flex gap-x-3">
                        <input class="h-5 w-5 custom-checkbox focus:border-blue-600 transition checked:border-blue-600 bg-contain rounded border border-slate-300 appearance-none" type="checkbox" id="is_closed" name="is_closed" onchange="toggleCloseDateSection()" value="1" id="is_checked" @checked(old('is_closed'))>
                        <label class="mb-0" for="is_closed">Ajouter une date de clotûre pour éviter quelques copies</label>
                    </div>
                </div>
                <div id="close-fg" class="form-group transition opacity-0 mb-7">
                    <div class="flex gap-x-4 mb-4">
                        <svg class="mt-1 text-slate-700" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-x" viewBox="0 0 16 16">
                            <path d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        <div>
                            <h6 class="font-bold text-sm">Date de clotûre</h6>
                            <p class="text-xs text-zinc-500">Date de cloture de la session, aucune réponse vont être accépter</small>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="form-group mb-8">
                            <label class="text-sm" for="close_at_date">Date de clotûre</label>
                            <input id="close_at_date" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full border-slate-200 outline-none py-1.5 px-2.5" type="date" name="close_at_date" value="{{ old('close_at_date') }}">
                            @error('close_at_date')
                            <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-8">
                            <label class="text-sm" for="close_at_time">Temps de clotûre</label>
                            <input id="close_at_time" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full border-slate-200 outline-none py-1.5 px-2.5" type="time" name="close_at_time" value="{{ old('close_at_time') }}">
                            @error('close_at_time')
                            <small class="text-red-600">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @error('close_date')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-span-4">
                <div class="form-group mb-6">
                    <label class="text-sm" for="points">Points</label>
                    <input id="points" step="1" class="rounded bg-slate-50 focus:bg-white border focus:ring-2 ring-blue-600 block w-full border-slate-200 outline-none py-1.5 px-2.5" type="number" min="0" name="points" value="{{ old('points') }}">
                </div>
                <div class="form-group mb-7">
                    <h6 class="text-sm font-bold mb-2">Références matériels</h6>
                    <input class="mt-2" type="file" multiple name="attachments[]" accept=".pdf, .docx, .doc, image/png, image/jpeg, image/jpg">
                </div>
            </div>
        </div>
    </form>
</div>
<script>
const closeFgEl = document.getElementById('close-fg');
function toggleCloseDateSection() {
    closeFgEl.classList.toggle('opacity-0')
}

const sheduleEl = document.getElementById('shedule');

const showSheduleSection = _ => sheduleEl.style.display = 'block';
const hideSheduleSection = _ => sheduleEl.style.display = 'none';

</script>
@endsection