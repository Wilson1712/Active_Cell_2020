//const guardarVenta = () => {
//    const Documento = document.getElementById('Documento');
//    const Nombre = document.getElementById('Nombre');
//    const Apellido = document.getElementById('Apellido');
//    const Telefono = document.getElementById('Telefono');
//   
//    let obj = {
//        Documento: Documento.value, 
//        Nombre: Nombre.value, 
//        Apellido: Apellido.value, 
//        Telefono: Telefono.value,
//        Precio: Precio.value,
//        productos:  arrayProducto
//    }
//
//    $.post(
//        URL + "Ventas/guardarVenta",
//        obj,
//        async (response) => {
//            await printThisDiv("tablaVentas")
//            location.reload();HTMLAudioElement
//        }
//    );
//
//
//        }
print() {
     let w=window.open("www.url.com/pdf"); 
     w.print(); 
     w.close();
 }