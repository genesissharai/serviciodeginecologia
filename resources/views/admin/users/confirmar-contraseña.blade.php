<!-- Modal -->
    @csrf
    <div class="modal fade" id="confirmarPasswordModal" tabindex="-1" role="dialog" aria-labelledby="confirmarPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmarPasswordModalLabel">Confirme contraseña</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="validarContraseña" action="/confirmPassword" method="POST">
                    <label for="">Contraseña</label>
                    <input type="password" name="contraseña">
                    <button type="button" class="btn btn-primary">Confirmar</button>
                </form>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
