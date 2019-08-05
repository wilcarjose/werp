<button class="btn waves-effect waves-set" type="{{ $action->getEvent() }}" name="{{ $action->getName() }}" value="{{ $action->getValue() }}"> {{ $action->getText() }}
    <i class="material-icons left">{{ $action->getIcon() }}</i>
</button>