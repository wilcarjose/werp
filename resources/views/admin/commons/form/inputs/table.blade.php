<div class="input-field col {{ $table->width() }}">
  <table>
    <thead>
      <tr>
        @foreach ($table->header() as $header)
          <th data-field="{{ $header->field() }}">{{ $header->label() }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
    
      @foreach ($table->rows() as $row)
        <tr>
    
          @foreach ($row->cells() as $cell)
            <td>
              @if ($cell->isCheck())
                <input type="checkbox" id="{{ $cell->getName() }}" name="{{ $cell->getName() }}" @if ($cell->isChecked()) checked="checked" @endif @if($cell->isDisabled()) disabled="disabled" @endif />
              @endif
              @if ($cell->isLabel())
                {{ $cell->label() }}
              @endif
            </td>
          @endforeach
    
        </tr>
      @endforeach
    
    </tbody>
  </table>
</div>