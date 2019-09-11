@if ($page->hasLists())

	<div class="col {{ $page->listsWidth() }}">

        @foreach ($page->getLists() as $list)

            <users headline='User' v-bind:config="{{$list->getConfig()}}"></users>

        @endforeach

    </div>

@endif