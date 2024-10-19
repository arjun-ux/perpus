<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    @if ($haveSet !== null)
    <p class="text-muted mb-1 mb-md-0">Copyright © {{ date('Y') }} {{ $haveSet->lembaga }}.</p>
    @else
    <p class="text-muted mb-1 mb-md-0">Copyright © {{ date('Y') }} .</p>
    @endif
    <p class="text-muted">Code By <strong><i>Arj</i></strong></p>
</footer>
