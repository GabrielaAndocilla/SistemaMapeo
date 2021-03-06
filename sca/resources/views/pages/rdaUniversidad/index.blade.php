@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
      <div class="panel-heading h-60">RDA de la Universidad <a class="link_" href="{{URL::to('/gestionar/rda-universidad/insertar')}}"><button class="btn-add" style="float:right">+</button></a></div>
        <div class="panel-body">
          @if (Session::has('mensaje'))
            <div class="alert alert-success">{{Session::get('mensaje', '')}}</div>
          @endif
          @if (Session::has('warning'))
            <div class="alert alert-warning">{{Session::get('warning', '')}}</div>
          @endif
            <table class="table table-bordered">
              <col width="50%">
              <col width="45%">
              <col width="5%">
              <thead>
              <tr>
                <th>Rda</th>
                <th>Logro Institucional</th>
                <th>Acción</th>
              </tr>
            </thead>
          @foreach($rdaUniversidad as $rda)
          <tr>
            <td>{{$rda->rda_universidad}}</td>
            <td>{{$rda->logros}}</td>
            <td>
              <a href="{{URL::to('/gestionar/rda-universidad').'/'.$rda->id.'/editar'}}"><span class="glyphicon glyphicon-pencil"></span></a>
              <a href="#" data-toggle="modal" data-target="#myModal" data-whatever="{{$rda->id}}" data-description="{{$rda->rda_universidad}}"  data-description="{{$rda->logros}}"><span class="glyphicon glyphicon-remove-circle"></a></span>
            </td>
          </tr>
          @endforeach
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p id="modal-question"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" id="modal-ok-btn">Eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
$('#myModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('whatever') // Extract info from data-* attributes
  var description = button.data('description');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('#modal-question').html("¿Desea eliminar <b>" + description + "</b>?");
  modal.find('#modal-ok-btn').click(function(){
    window.location = "{{URL::to('/gestionar/rda-universidad').'/'}}" + id + "{{'/eliminar'}}";
  });
})
</script>
@endsection
