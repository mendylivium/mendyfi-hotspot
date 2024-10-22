<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ trim($label) }}"
        aria-expanded="true" aria-controls="collapse{{ trim($label) }}">
        <i class="{{ $icon }}"></i>
        <span>{{ strtoupper($label) }}</span>
    </a>
    <div id="collapse{{ trim($label) }}"
        class="collapse {{ strpos(request()->route()->getName(),$route) !== false? 'show': '' }}"
        aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            {{-- <h6 class="collapse-header">Custom Utilities:</h6> --}}
            {{ $slot }}
        </div>
    </div>
</li>
