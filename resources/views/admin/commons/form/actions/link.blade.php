<a type="{{ $action->getType() }}" href="#" onclick="confirmAction('{{ $action->getRoute() }}'); return false;" class="btn waves-effect waves-set info-bg">
    {{ $action->getText() }}
</a>
