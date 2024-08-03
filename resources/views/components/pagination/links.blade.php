@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1">
                <span>
                    @if ($paginator->onFirstPage())
                        <span
                            class="btn btn-disabled">
                            @svg('eva-arrowhead-left', ['class' => 'w-5 h-5'])
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="font-normal btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400">
                            @svg('eva-arrowhead-left', ['class' => 'w-5 h-5'])
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="font-normal btn btn-neutral text-primary-500 bg-surface-300 hover:bg-surface-400">
                            @svg('eva-arrowhead-right', ['class' => 'w-5 h-5'])
                        </button>
                    @else
                        <span
                            class="btn btn-disabled">
                            @svg('eva-arrowhead-right', ['class' => 'w-5 h-5'])
                        </span>
                    @endif
                </span>
            </div>
        </nav>
    @endif
</div>
