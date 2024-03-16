<x-layout pageTitle="Nutzer {{ $user->name }}" orientation="top">
    <div class="pb-6 grid grid-cols-2 gap-3">
        <div class="font-bold">Vorname:</div>
        <div>{{ $user->given_name }}</div>
        <div class="font-bold">Nachname:</div>
        <div>{{ $user->family_name }}</div>
        <div class="font-bold">Nutzername:</div>
        <div>{{ $user->username }}</div>
    <hr / class="col-span-2">
    </div>
    <a class="text-indigo-700" href="{{ route('users.index') }}">Zurück zur Übersicht</a>
</x-layout>