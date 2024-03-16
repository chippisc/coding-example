<x-layout pageTitle="Nutzersuche">
    <users csrf="{{ csrf_token() }}" url="{{ route('users.fetch') }}"></users>
</x-layout>