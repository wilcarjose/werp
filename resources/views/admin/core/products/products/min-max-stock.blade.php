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
          <th class="center-align qty-box">Máximo</th>
          <th class="center-align qty-box">Mínimo</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td class="green-text"> <strong>Todos los almacenes</strong></td>
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
          <td class="center-align qty-box">
            <p class="caption">{{ $all_warehouse->max_qty ?: '0' }}</p>
            <p class="grey-text">Unidades</p>
            <a class="btn-floating waves-effect waves-light btn-flat edit-qty" href="javascript:void(0)" style="display: none;">
              <i class="material-icons primary-text">edit</i>
            </a>
            <div style="display: none;">
              <input type="number" name="qty" value="{{ $all_warehouse->max_qty ?: '0' }}" style="width: 40px;">
              <input type="hidden" name="type" value="max">
              <input type="hidden" name="warehouse_id" value="{{ null }}">
              <input type="hidden" name="product_id" value="{{ $product_id }}">
              <a class="btn-floating waves-effect waves-light btn-flat save-qty" href="javascript:void(0)" style="width: 25px; height: 25px;">
                <i class="material-icons primary-text" style="line-height: 25px;">save</i>
              </a>
              <a class="btn-floating waves-effect waves-light btn-flat cancel-edit" href="javascript:void(0)" style="width: 25px; height: 25px;">
                <i class="material-icons red-text" style="line-height: 25px;">cancel</i>
              </a>
            </div>
          </td>
          <td class="center-align qty-box">
            <p class="caption">{{ $all_warehouse->min_qty ?: '0' }}</p>
            <p class="grey-text">Unidades</p>
            <a class="btn-floating waves-effect waves-light btn-flat edit-qty" href="javascript:void(0)" style="display: none;">
              <i class="material-icons primary-text">edit</i>
            </a>
            <div style="display: none;">
              <input type="number" name="qty" value="{{ $all_warehouse->min_qty ?: '0' }}" style="width: 40px;">
              <input type="hidden" name="type" value="min">
              <input type="hidden" name="warehouse_id" value="{{ null }}">
              <input type="hidden" name="product_id" value="{{ $product_id }}">
              <a class="btn-floating waves-effect waves-light btn-flat save-qty" href="javascript:void(0)" style="width: 25px; height: 25px;">
                <i class="material-icons primary-text" style="line-height: 25px;">save</i>
              </a>
              <a class="btn-floating waves-effect waves-light btn-flat cancel-edit" href="javascript:void(0)" style="width: 25px; height: 25px;">
                <i class="material-icons red-text" style="line-height: 25px;">cancel</i>
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td class="grey-text"> <strong>Por almacén</strong></td>
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
            <td class="center-align qty-box">
              <p class="caption qty">{{ $limit->max_qty ?: '0' }}</p>
              <p class="grey-text qty-uom">Unidades</p>
              <a class="btn-floating waves-effect waves-light btn-flat edit-qty" href="javascript:void(0)" style="display: none;">
                <i class="material-icons primary-text">edit</i>
              </a>
              <div style="display: none;">
                <input type="number" name="qty" value="{{ $limit->max_qty ?: '0' }}" style="width: 40px;">
                <input type="hidden" name="type" value="max">
                <input type="hidden" name="warehouse_id" value="{{ $limit->warehouse_id }}">
                <input type="hidden" name="product_id" value="{{ $product_id }}">
                <a class="btn-floating waves-effect waves-light btn-flat save-qty" href="javascript:void(0)" style="width: 25px; height: 25px;">
                  <i class="material-icons primary-text" style="line-height: 25px;">save</i>
                </a>
                <a class="btn-floating waves-effect waves-light btn-flat cancel-edit" href="javascript:void(0)" style="width: 25px; height: 25px;">
                  <i class="material-icons red-text" style="line-height: 25px;">cancel</i>
                </a>
              </div>
            </td>
            <td class="center-align qty-box">
              <p class="caption qty">{{ $limit->min_qty ?: '0' }}</p>
              <p class="grey-text qty-uom">Unidades</p>
              <a class="btn-floating waves-effect waves-light btn-flat edit-qty" href="javascript:void(0)" style="display: none;">
                <i class="material-icons primary-text">edit</i>
              </a>
              <div style="display: none;">
                <input type="number" name="qty" value="{{ $limit->min_qty ?: '0' }}" style="width: 40px;">
                <input type="hidden" name="type" value="min">
                <input type="hidden" name="warehouse_id" value="{{ $limit->warehouse_id }}">
                <input type="hidden" name="product_id" value="{{ $product_id }}">
                <a class="btn-floating waves-effect waves-light btn-flat save-qty" href="javascript:void(0)" style="width: 25px; height: 25px;">
                  <i class="material-icons primary-text" style="line-height: 25px;">save</i>
                </a>
                <a class="btn-floating waves-effect waves-light btn-flat cancel-edit" href="javascript:void(0)" style="width: 25px; height: 25px;">
                  <i class="material-icons red-text" style="line-height: 25px;">cancel</i>
                </a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>



@push('extra-js')

  <script>

      var editing = false;

      $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

      });
    
      $( ".qty-box" ).hover(
        function() {
          if (!editing) {
            $(this).children().first().addClass( "qty-hover" );
            $(this).children().first().next().addClass( "qty-hover" );
            $(this).children().first().next().next().addClass( "show-edit-qty" );
          }
        }, function() {
          if (!editing) {
            $(this).children().first().removeClass( "qty-hover" );
            $(this).children().first().next().removeClass( "qty-hover" );
            $(this).children().first().next().next().removeClass( "show-edit-qty" );
          }
        }
      );

      $( ".edit-qty" ).click(function() {
          editing = true;
          $(this).removeClass( "show-edit-qty" );
          $(this).prev().hide();
          $(this).prev().prev().hide();
          $(this).next().show();
      });

      $( ".cancel-edit" ).click(function() {
          editing = false;
          $(this).parent().prev().addClass( "show-edit-qty" );
          $(this).parent().prev().prev().show();
          $(this).parent().prev().prev().prev().show();
          $(this).parent().hide();
      });

      $( ".save-qty" ).click(function(e) {

        e.preventDefault();

        var qty = $(this).prev().prev().prev().prev().val();
        var type = $(this).prev().prev().prev().val();
        var warehouse_id = $(this).prev().prev().val();
        var product_id = $(this).prev().val();

        $.ajax({
           type:'POST',
           url:'/admin/products/products/' + product_id + '/limits',
           data:{qty:qty, type:type, warehouse_id:warehouse_id},
           success:function(data){
              console.log(data);
              
           },
           error: function(error) {
              console.log(error);
           }

        });

        $(this).parent().prev().prev().prev().html(qty);
        $(this).parent().prev().addClass( "show-edit-qty" );
        $(this).parent().prev().prev().show();
        $(this).parent().prev().prev().prev().show();
        $(this).parent().hide();
        editing = false;

      });


  </script>

@endpush