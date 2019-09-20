<a type="{{ $action->getType() }}" href="{{ $action->getRoute() }}" class="btn waves-effect waves-set info-bg">
    <i class="material-icons {{ $action->getIconPosition() }}">{{ $action->getIcon() }}</i> {{ $action->getText() }}
</a>
