{!! Form::open(['route'=>['sacademica.ability.destroy',$ability->id],'method'=>'delete']) !!}
<div class="modal fade" id="modal-delete-{{$ability->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger"></i> Confirmar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            ¿Esta seguro que desea eliminar esta capacidad del modulo formativo del sistema?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fas fa-power-off"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}