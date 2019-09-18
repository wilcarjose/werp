<div class="card">
  <div class="card-content">
    <div class="row no-mrpd">
      <div class="col s8"><span class="card-title">Máximos y mínimos</span></div>
      <div class="col s4 right-align"><a class="dropdown-button page-opt-dropBtn btn-floating btn-flat waves-effect waves-set setWave" href="javascript:void(0)" data-activates="supportTicket" data-beloworigin="true" data-alignment="right" data-position="bottom" data-constrainwidth="false" data-delay="50" data-gutter="25"><i class="material-icons grey-text text-darken-2">menu</i></a></div>
    </div>
    <table class="responsive-table statistic-table">
      <thead>
        <tr>
          <th class="user-th">Almacén</th>
          <th class="center-align">Máximo</th>
          <th class="center-align">Mínimo</th>
          <th class="left-align">Actualizado</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td class="green-text"> <strong>Todos los almacenes</strong></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>
            <div class="left"><a class="btn-floating waves-effect waves-set setWave pink accent-4 center-align" href="#">T</a></div>
            <div class="left pad-left-8">
              <p>Todos</p>
              <p class="blue-text"><small>Activo</small></p>
            </div>
          </td>
          <td class="center-align">
            <p class="caption">{{ $all_warehouse->max_qty ?: '0' }}</p>
            <p class="grey-text">Unidades</p>
          </td>
          <td class="center-align">
            <p class="caption">{{ $all_warehouse->max_qty ?: '0' }}</p>
            <p class="grey-text">Unidades</p>
          </td>
          <td>
            <p class="grey-text text-darken-1" style="font-size: 11px;">{{ $all_warehouse->updated_at ?: '' }}</p>
          </td>
        </tr>
        <tr>
          <td class="grey-text"> <strong>Por almacén</strong></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        @foreach ($limits as $limit)
          <tr>
            <td>
              <div class="left"><a class="btn-floating waves-effect waves-set setWave accent-4 center-align" style="background-color: {{ $limit->warehouse->color }} !important;" href="#">{{ $limit->warehouse->abbr }}</a></div>
              <div class="left pad-left-8">
                <p>{{ $limit->warehouse->name }} </p>
                <p class="blue-text"><small>Activo</small></p>
              </div>
            </td>
            <td class="center-align">
              <p class="caption">{{ $limit->max_qty ?: '0' }}</p>
              <p class="grey-text">Unidades</p>
            </td>
            <td class="center-align">
              <p class="caption">{{ $limit->min_qty ?: '0' }}</p>
              <p class="grey-text">Unidades</p>
            </td>
            <td>
              <p class="grey-text text-darken-1" style="font-size: 11px;">{{ $limit->updated_at ?: '' }}</p>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
