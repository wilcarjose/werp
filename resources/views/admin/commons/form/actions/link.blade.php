<a type="{{ $action->getType() }}" @if($action->confirm()) href="#" onclick="confirmAction('{{ $action->getRoute() }}'); return false;" @else href="{{ $action->getRoute() }}" @endif class="btn waves-effect waves-set info-bg">
    {{ $action->getText() }}
</a>
