<div class="input-field col {{ $table->width() }}" xmlns:text-align="http://www.w3.org/1999/xhtml">
  <table>
    <thead>
      <tr>
        @foreach ($table->header() as $index => $header)
          <th data-field="{{ $header->field() }}" @if ($index == 3) style="text-align: right;" @endif>{{ $header->label() }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>

      @foreach ($table->rows() as $row)
        <tr>

          @foreach ($row->cells() as $cell)
            <td>
              @if ($cell->isCheck())
                <input type="checkbox" id="{{ $cell->id }}" name="{{ $cell->name }}" @if ($cell->isChecked) checked="checked" @endif @if($cell->isDisabled) disabled="disabled" @endif />
              @endif
              @if ($cell->isLabel())
                {{ $cell->label() }}
              @endif
              @if ($cell->isInput())
                <input type="text" id="{{ $cell->data()->id }}" name="{{ $cell->data()->name }}[{{$cell->data()->id}}]" value="{{ $cell->data()->value }}" style="text-align: right; border: 0; color: #000;" readonly>
              @endif
            </td>
          @endforeach

        </tr>
      @endforeach

    </tbody>
  </table>
</div>
