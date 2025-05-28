
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
            alert('Producto insertado correctamente');
            formulario.reset();
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

    if (formulario.get('codigo') == '') {
        alert('el codigo es obligatorio');
        return false;
    }

    if (!validarCodigo(formulario.get('codigo'))) {
        alert('el codigo debe tener solo caracteres y tener una longitud minima de 5 caracteres y maxima de 15');
        return false;
    }

    if (formulario.get('nombre') == '') {
        alert('el nombre es obligatorio');
        return false;
    }

    if (!validarNombre(formulario.get('nombre'))) {
        alert('el nombre debe tener solo caracteres y tener una longitud minima de 2 caracteres y maxima de 50');
        return false;
    }

    if (formulario.get('bodega') == 'none') {
        alert('debe seleccionar una bodega');
        return false;
    }

    if (formulario.get('sucursal') == 'none') {
        alert('debe seleccionar una sucursal');
        return false;
    }

    if (formulario.get('moneda') == 'none') {
        alert('debe seleccionar una moneda');
        return false;
    }

    if (formulario.get('precio') == '') {
        alert('el precio es obligatorio');
        return false;
    }

    if (!validarPrecio(formulario.get('precio'))) {
        alert('el precio debe ser un numero y tener maximo 2 decimales');
        return false;
    }
    if (countchecked < 2) {
        alert('debe seleccionar al menos 2 materiales');
        return;
    }

    if (formulario.get('descripcion') == '') {
        alert('la descripcion es obligatoria');
        return false;
    }

    if (!validarDescripcion(formulario.get('descripcion'))) {
        alert('la descripcion debe tener una longitud minima de 10 caracteres y maxima de 1000');
        return false;
    }


    return true;
}


function validarCodigo(codigo) {
    const regex = /^[a-zA-Z0-9]{5,15}$/;
    return regex.test(codigo);
}

function validarNombre(nombre) {
    const regex = /^[a-zA-Z0-9 ]{2,50}$/;
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