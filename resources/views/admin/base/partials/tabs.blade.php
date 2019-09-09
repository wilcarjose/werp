@if ($page->hasTabs())

    <div class="row" style="padding: 0 0.75rem !important;">

        <div class="col {{ $page->tabsWidth() }}" style="margin-bottom: 15px;">

            <ul class="tabs tab-demo z-depth-1">

                @foreach ($page->getTabs() as $tab)

                    <li class="tab col s3 @if ($tab->isDisable()) disabled @endif">

                        <a @if ($tab->isActive()) class="active" @endif href="#{{ $tab->getId() }}" style="text-align: left; color: {{ $tab->getColor() }}">

                            <i class="material-icons {{ $tab->getIconPosition() }}" style="line-height: 48px;">

                                {{ $tab->getIcon() }}

                            </i>

                            {{ $tab->getName() }}

                        </a>

                    </li>

                @endforeach

            </ul>
            
        </div>

    </div>

@endif