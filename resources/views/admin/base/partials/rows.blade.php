<div class="col {{ $page->rowsWidth() }}">

	@foreach ($page->rows() as $row)

		<div class="row" id="{{ $row->getId() }}">

			@foreach ($row->cols() as $col)

				<div class="col {{ $col->width() }}">

					@foreach ($col->forms() as $form)

						@include('admin.base.partials.form')

					@endforeach

					@foreach ($col->cards() as $card)

						@includeIf($card->view()->name(), $card->data())

					@endforeach

				</div>

			@endforeach

		</div>

	@endforeach

</div>
