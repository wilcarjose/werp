<button class="{{ $action->getClass() }}" type="{{ $action->getEvent() }}" name="{{ $action->getName() }}" value="{{ $action->getValue() }}"> {{ $action->getText() }}
    <i class="material-icons {{ $action->getIconPosition() }}">{{ $action->getIcon() }}</i>
</button>