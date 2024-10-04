<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <x-mail::header :url="config('app.url')">
            {{ config('app.name') }}
        </x-mail::header>
    </x-slot:header>

    {{-- Body --}}
    Hello po {{ $name }}
    <x-mail::panel>
        This is the panel content....
    </x-mail::panel>

    <x-slot:subcopy>
        <x-mail::subcopy>
            Confidential Notice:
            This email and any attachments are confidential and intended solely for the recipient. If received in error,
            please notify the sender and delete it. Unauthorized distribution or use is prohibited.
        </x-mail::subcopy>
    </x-slot:subcopy>

    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
