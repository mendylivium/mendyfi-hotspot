<x-layouts.guest>
    <div class="text-center py-2">
        <span class="text text-lg text-dark">UNREGISTERED DOMAIN</span>
        <br>
        <span class="text text-danger">
            "{{ request()->getHost() }}"
        </span>
        <br>
        <br>
        <span class="text text-dark">
            Please Contact Web Administrator
        </span>
    </div>
</x-layouts.guest>
