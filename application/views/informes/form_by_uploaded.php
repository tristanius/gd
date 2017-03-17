

  <form class="form-horizontal" method="POST" action="<?= site_url('informe/get/uploaded') ?>"  style="overflow:hidden">
    <fieldset>
      <h4 class="texto-normal">Genera un listado de la base que perteneces en el sistema:</h4>
      <input name="base" type="hidden" value="<?= $id ?>" />
      <div class="form-group">
        <label class="col-xs-2">Ver en la web
          <div class="col-xs-2">
            <input type="checkbox" name="web">
          </div>
        </label>
      </div>
      <div class="clear">
        <button class="btn btn-success">Generar informe</button>
      </div>
    </fieldset>
  </form>
