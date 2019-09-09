<div class="card">
  <div class="card-content"><span class="card-title">Existencia</span>

    <table>
      <thead>
        <tr>
          <th class="application-th">Almacén</th>
          <th class="time-th right-align">Cantidad</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($stock as $wh)
          <tr>
            <td>
              <div class="left"><a class="btn-floating waves-effect waves-set setWave accent-4 center-align" href="#" style="background-color: {{ $wh->warehouse->color }} !important;">{{ $wh->warehouse->abbr }}</a></div>
              <div class="left pad-left-8">
                <p>{{ $wh->warehouse->name }}</p><a class="green-text" href="#!">Nuevo<i class="material-icons left">add</i></a>
              </div>
            </td>
            <td class="right-align">
              <p class="grey-text text-darken-2" style="font-weight: 600;"> {{ $wh->qty }}</p>
            </td>
          </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>
</div>