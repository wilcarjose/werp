@if ($page->hasForms())

    <div class="col {{ $page->formsWidth() }}">

        @foreach ($page->getForms() as $form)

            @include('admin.base.partials.form')

        @endforeach

    </div>

@endif