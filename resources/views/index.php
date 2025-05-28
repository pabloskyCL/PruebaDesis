<?php

use app\Http\URL;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/views/styles.css" >
    <script src="/resources/views/validadorFormulario.js" defer></script>
    <title>Registro de productos</title>
</head>
<body>
<div class="container">
      <form id="registro-producto" class="product-form">
          <h2>Formulario de Producto</h2>
        
          <div class="form-row">
          <div class="form-group">
              <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo">
          </div>
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="bodega">Bodega</label>
            <select id="bodega" name="bodega">
            <option value="none"></option>
            <?php

 foreach ($data['bodegas'] as $bodega) {?>
                <option value="<?php echo $bodega->id; ?>"><?php echo $bodega->nombre; ?></option>
                <?php }?>
            </select>
          </div>
          <div class="form-group">
            <label for="sucursal">Sucursal</label>
            <select id="sucursales" name="sucursal">
            <option value="none"></option>
            <!-- agrega las sucursales con una consulta ajax -->
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
          <label for="moneda">Moneda</label>
        <select name="moneda" id="moneda">
            <option value="none"></option>
            <?php foreach ($data['monedas'] as $moneda) {?>
                <option value="<?php echo $moneda->id; ?>"><?php echo $moneda->nombre; ?></option>
                <?php }?>
        </select>
          </div>
          <div class="form-group">
            <label for="precio">Precio</label>
            <input type="text" id="precio" name="precio">
          </div>
        </div>

        <div class="form-group">
          <label>Material del Producto</label>
          <div class="checkbox-group">
            <label><input type="checkbox" id="plastico" name="plastico" value="plastico"> Plástico</label>
            <label><input type="checkbox" id="metal" name="metal" value="metal"> Metal</label>
            <label><input type="checkbox" id="madera" name="madera" value="madera"> Madera</label>
            <label><input type="checkbox" id="vidrio" name="vidrio" value="vidrio"> Vidrio</label>
            <label><input type="checkbox" id="textil" name="textil" value="textil"> Textil</label>
        </div>
    </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
          <textarea id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        
        <button type="submit" class="submit-btn">Guardar Producto</button>
    </form>
</div>
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            let bodega = document.getElementById('bodega');
            let sucursales = document.getElementById('sucursales');
            
            bodega.addEventListener('change', getSucursales);

            // obtiene las sucursales sugún la bodega seleccionada
            
            // valida los datos del formulario y lo envia
            formulario.addEventListener('submit', enviarFormulario);

        });

    </script>
</body>
</html>
