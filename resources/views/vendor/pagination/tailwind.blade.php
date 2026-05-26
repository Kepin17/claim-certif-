@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-top:24px;padding:16px 0;flex-wrap:wrap;">

    <p style="font-size:13px;color:#8A877F;margin:0;">
        Showing
        @if ($paginator->firstItem())
            <strong style="color:#131210;">{{ $paginator->firstItem() }}</strong>
            &ndash;
            <strong style="color:#131210;">{{ $paginator->lastItem() }}</strong>
        @else
            {{ $paginator->count() }}
        @endif
        of
        <strong style="color:#131210;">{{ $paginator->total() }}</strong>
        results
    </p>

    <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;font-weight:500;color:#C5C2BB;border:1px solid rgba(0,0,0,0.08);border-radius:6px;background:#FDFCFA;cursor:not-allowed;user-select:none;">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;font-weight:500;color:#4A4740;border:1px solid rgba(0,0,0,0.08);border-radius:6px;background:#FDFCFA;text-decoration:none;" onmouseover="this.style.background='#F5F2EC'" onmouseout="this.style.background='#FDFCFA'">&lsaquo;</a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;color:#8A877F;">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;font-weight:600;color:#FFFFFF;border:1px solid #2D5016;border-radius:6px;background:#2D5016;cursor:default;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;font-weight:500;color:#4A4740;border:1px solid rgba(0,0,0,0.08);border-radius:6px;background:#FDFCFA;text-decoration:none;" onmouseover="this.style.background='#F5F2EC'" onmouseout="this.style.background='#FDFCFA'">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;font-weight:500;color:#4A4740;border:1px solid rgba(0,0,0,0.08);border-radius:6px;background:#FDFCFA;text-decoration:none;" onmouseover="this.style.background='#F5F2EC'" onmouseout="this.style.background='#FDFCFA'">&rsaquo;</a>
        @else
            <span style="display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-size:13px;font-weight:500;color:#C5C2BB;border:1px solid rgba(0,0,0,0.08);border-radius:6px;background:#FDFCFA;cursor:not-allowed;user-select:none;">&rsaquo;</span>
        @endif

    </div>
</nav>
@endif
