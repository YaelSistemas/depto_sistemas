    <!-- Modal -->
    <form id="frmPassword" onsubmit="return cambio_password()">
        <div class="modal fade" id="cambiar_password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Escribe el Nuevo Password</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" hidden name="id_usuario" id="id_usuario">
                    <label for="password">Password Nuevo</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="modal-footer">
                  <span class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</span>
                  <button class="btn btn-warning">Actualizar Password</button>
                </div>
              </div>
            </div>
          </div>
    </form>
