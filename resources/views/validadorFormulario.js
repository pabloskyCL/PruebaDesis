
let bodega = document.getElementById('bodega');
let sucursales = document.getElementById('sucursales');
let formulario = document.getElementById('registro-producto');
let baseUrl = 'http://desisproducts.local';

function getSucursales(event) {
    // let bodega = event.target.value;
    let bodegaVal = bodega.value;
    if (bodegaVal == "none") {
        sucursales.options.length = 0;

        sucursales.add(new Option('', 'none'));
        return false;
    }

    let peticion = new XMLHttpRequest();
    peticion.open('GET', baseUrl + '/sucursales?bodega=' + bodegaVal, true);
    peticion.onload = function () {
        let data = JSON.parse(this.response);
        // Clear all options at once
        sucursales.options.length = 0;

        sucursales.add(new Option('', 'none'));
        data.data.sucursales.forEach((value, index) => {
            sucursales.add(new Option(value.nombre, value.id));
        });
    }
    peticion.send();
}

function enviarFormulario(event) {
    event.preventDefault();
    let datos = new FormData(formulario);

    if (!validarFormulario(datos)) {
        return;
    }

    let peticion = new XMLHttpRequest();
    peticion.open('POST', baseUrl + '/producto', true);
    peticion.onload = function () {
        let data = JSON.parse(this.response);
        if (data.code == 500) {
            alert(data.data.error);
            return;
        }

        if (data.code == 201) {
            alert('Producto creado correctamente');
            formulario.reset();
            sucursales.options.length = 0;
            sucursales.add(new Option('', 'none'));
            return;
        }

    }

    peticion.send(datos);

}


function validarFormulario(formulario) {

    let plastico = formulario.get('plastico');
    let metal = formulario.get('metal');
    let madera = formulario.get('madera');
    let vidrio = formulario.get('vidrio');
    let textil = formulario.get('textil');

    let countchecked = [plastico, metal, madera, vidrio, textil].reduce((acc, value) => {
        if (value) {
            acc++;
        }
        return acc;
    }, 0);

    let codigo = formulario.get('codigo');

    if (codigo == '') {
        alert('El código del producto no puede estar en blanco.');
        return false;
    }

    if (!validarFormatoCodigo(codigo)) {
        alert('El código del producto debe contener letras y números');
        return false;
    }

    if (!validarLargoCodigo(codigo)) {
        alert('El código del producto debe tener entre 5 y 15 caracteres');
        return false;
    }

    if (formulario.get('nombre') == '') {
        alert('El nombre del producto no puede estar en blanco');
        return false;
    }

    if (!validarNombre(formulario.get('nombre'))) {
        alert('El nombre del producto debe tener entre 2 y 50 caracteres.');
        return false;
    }

    if (formulario.get('bodega') == 'none') {
        alert('Debe seleccionar una bodega.');
        return false;
    }

    if (formulario.get('sucursal') == 'none') {
        alert('Debe seleccionar una sucursal para la bodega seleccionada.');
        return false;
    }

    if (formulario.get('moneda') == 'none') {
        alert('El precio del producto no puede estar en blanco.');
        return false;
    }

    if (formulario.get('precio') == '') {
        alert('el precio es obligatorio');
        return false;
    }

    if (!validarPrecio(formulario.get('precio'))) {
        alert('El precio del producto debe ser un número positivo con hasta dos decimales.');
        return false;
    }
    if (countchecked < 2) {
        alert('Debe seleccionar al menos dos materiales para el producto.');
        return;
    }

    if (formulario.get('descripcion') == '') {
        alert('La descripción del producto no puede estar en blanco.');
        return false;
    }

    if (!validarDescripcion(formulario.get('descripcion'))) {
        alert('La descripción del producto debe tener entre 10 y 1000 caracteres.');
        return false;
    }


    return true;
}


function validarLargoCodigo(codigo) {
    const regex = /^.{5,15}$/;
    return regex.test(codigo);
}

function validarFormatoCodigo(codigo) {
    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/;
    return regex.test(codigo);
}

function validarNombre(nombre) {
    const regex = /^.{2,50}$/;
    return regex.test(nombre);
}

function validarPrecio(precio) {
    const regex = /^\d+(\.\d{1,2})?$/;
    return regex.test(String(precio));
}

function validarDescripcion(descripcion) {
    const regex = /^.{10,1000}$/s;
    return regex.test(descripcion);
}