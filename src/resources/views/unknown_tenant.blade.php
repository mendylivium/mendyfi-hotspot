<x-layouts.guest>
    @if ($type == 'domain')
        <div class="text-center p-2">
            <span class="text text-lg text-dark">UNREGISTERED</span>
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
    @else
        <div class="text-center p-2">
            <span class="text text-lg text-dark">NO IDENTFIER SPECIFIED or UNKOWN <span
                    class="text text-danger">"tenant"</span></span>
            <br>
            <span class="text text-dark">
                Please Contact Web Administrator, to get your Link with tenant identifier
            </span>
        </div>
    @endif
</x-layouts.guest>
