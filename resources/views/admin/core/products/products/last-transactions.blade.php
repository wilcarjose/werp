<div class="card">
  <div class="card-content"><span class="card-title">Últimas transacciones</span>
    <table>
      <thead>
        <tr>
          <th class="application-th">Movimiento</th>
          <th class="time-th right-align">Cantidad</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($transactions as $tx)
          <tr>
            <td>
              <div class="left"><a class="btn-floating waves-effect waves-set setWave accent-4 center-align" href="#" style="background-color: {{ get_color_by_tx_type($tx->type) }} !important;">{{ get_transaction_initials($tx->type) }}</a></div>
              <div style="padding-left: 55px">
                <p>{{ get_transaction_name($tx->type) }}</p>
                <p class="grey-text text-darken-1"> {{ $tx->warehouse->name }} </p>
                <p> <a class="blue-text" href="{{ get_process_url($tx->type, $tx->process_id) }}" target="_blank"> {{ $tx->reference }} </a> </p>
                <p> {{ get_date_format($tx->date, 'd/m/Y') }} </p>
              </div>
            </td>
            <td class="right-align">
              <p class="{{ $tx->qty < 0 ? 'red-text' : 'green-text'}} text-darken-2" style="font-weight: 600;"> {{ $tx->qty }}</p>
            </td>
          </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>
</div>