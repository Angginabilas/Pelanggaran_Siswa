@if ($paginator->hasPages())
    <nav>
        <ul class="pagination" style="display:flex;align-items:center;gap:4px;flex-wrap:wrap;list-style:none;margin:0;padding:0;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" style="display:inline-block;">
                    <span style="display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;font-weight:500;font-size:0.85rem;color:#94a3b8;background:#f1f5f9;border:1px solid #e2e8f0;cursor:not-allowed;">
                        <i class="bi bi-chevron-left"></i> Sebelumnya
                    </span>
                </li>
            @else
                <li style="display:inline-block;">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;font-weight:500;font-size:0.85rem;color:var(--primary);background:#fff;border:1px solid #e2e8f0;text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='var(--primary-light)';this.style.borderColor='var(--primary)'"
                       onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                        <i class="bi bi-chevron-left"></i> Sebelumnya
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" style="display:inline-block;">
                        <span style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:10px;font-weight:500;font-size:0.85rem;color:#94a3b8;background:transparent;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li style="display:inline-block;">
                                <span style="display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:10px;font-weight:700;font-size:0.85rem;color:#fff;background:var(--primary);box-shadow:0 2px 8px rgba(79,70,229,0.3);">{{ $page }}</span>
                            </li>
                        @else
                            <li style="display:inline-block;">
                                <a href="{{ $url }}" style="display:flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:10px;font-weight:500;font-size:0.85rem;color:var(--gray);background:#fff;border:1px solid #e2e8f0;text-decoration:none;transition:all 0.2s;"
                                   onmouseover="this.style.background='var(--primary-light)';this.style.borderColor='var(--primary)';this.style.color='var(--primary)'"
                                   onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='var(--gray)'">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li style="display:inline-block;">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;font-weight:500;font-size:0.85rem;color:var(--primary);background:#fff;border:1px solid #e2e8f0;text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='var(--primary-light)';this.style.borderColor='var(--primary)'"
                       onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                        Selanjutnya <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="disabled" style="display:inline-block;">
                    <span style="display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;font-weight:500;font-size:0.85rem;color:#94a3b8;background:#f1f5f9;border:1px solid #e2e8f0;cursor:not-allowed;">
                        Selanjutnya <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
