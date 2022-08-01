<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagina principal</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-5">
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="Cliente" Disabled>
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#exampleModal">Button</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Clientes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           <form id="my-form">
            <div class="container">
              
              <div class="row">
                <div class="col-3">
                  Nombres
                </div>
                <div class="col-3">
                  Ap. Paterno
                </div>
                <div class="col-3">
                  Ap. Materno
                </div>
                <div class="col-3">
                  Fecha de nacimiento
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <input type="text" class="form-control" id="FAnv_Nombres" for="validationCustomUsername"required>
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="FAnv_APaterno" for="validationCustomUsername" required>
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="FAnv_AMaterno" for="validationCustomUsername" required>
                </div>
                <div class="col-3">
                  <input type="date" class="form-control" id="FAdt_FecNac" for="validationCustomUsername" required>
                </div>
              </div>
              
              <div class="row">
                <div class="col-4">
                  CURP
                </div>
                <div class="col-4">
                  RFC
                </div>
                <div class="col-4">
                  INE
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <input type="text" class="form-control" id="FAnv_CURP">
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="FAnv_RFC">
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="FAnv_IFE">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-3">
                  CP
                </div>
                <div class="col-3">
                  Colonia
                </div>
                <div class="col-4">
                  Calle
                </div>
                <div class="col-2">
                  Ciudad
                </div>
              </div>
              <div class="row">
                <div class="col-3">
                  <input type="text" class="form-control" id="FAnv_ApartadoPost">
                </div>
                <div class="col-3">
                  <select class="form-select" id="FAnv_FiscalColonia">
                  </select>
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="FAnv_Calle">
                </div>
                <div class="col-2">
                  <input type="text" class="form-control" id="FAnv_FiscalCd" disabled>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-4">
                  Telefono
                </div>
                <div class="col-4">
                  Celular
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <input type="text" class="form-control" id="FAnv_Tel">
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="FAnv_Cel">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                <button type="button" id="limpiar" class="btn btn-warning float-right" >Limpiar</button>
                </div>
              </div>
              
            </div>
           </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success" id="boton" data-placement="bottom">Aceptar</button>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
       const FAnv_FiscalColonia = document.getElementById('FAnv_FiscalColonia');
	     const FAnv_ApartadoPost = document.getElementById('FAnv_ApartadoPost');
	     const FAnv_APaterno = document.getElementById('FAnv_APaterno');
	     const FAnv_AMaterno = document.getElementById('FAnv_AMaterno');
	     const FAnv_FiscalCd = document.getElementById('FAnv_FiscalCd');
       const FAnv_Nombres = document.getElementById('FAnv_Nombres');
       const FAdt_FecNac = document.getElementById('FAdt_FecNac');
	     const FAnv_Calle = document.getElementById('FAnv_Calle');
       const FAnv_CURP = document.getElementById('FAnv_CURP');
       const FAnv_Tel = document.getElementById('FAnv_Tel');
	     const FAnv_Cel = document.getElementById('FAnv_Cel');
       const FAnv_RFC = document.getElementById('FAnv_RFC');
       const FAnv_IFE = document.getElementById('FAnv_IFE');
       const limpiar = document.getElementById('limpiar');
       const Cliente = document.getElementById('Cliente');
	     const Tool = document.getElementById('tooltip');
       const boton = document.getElementById('boton');
       var Colonos;
       var Cli;

       FAnv_ApartadoPost.addEventListener('keyup', Colonias);
       FAnv_AMaterno.addEventListener('keyup', Tecla);
       limpiar.addEventListener('click', Limpiar);
       boton.addEventListener('click', Aceptar);

       function Limpiar(e){
         FAnv_Nombres.value = "";
		     FAnv_APaterno.value = "";
		     FAnv_AMaterno.value = "";
		     FAnv_FiscalCd.value = "";
         FAnv_ApartadoPost.value = "";
		     FAnv_Calle.value = "";
		     FAnv_Tel.value = "";
		     FAnv_Cel.value = "";
		     FAnv_CURP.value = "";
		     FAnv_RFC.value = "";
		     FAnv_IFE.value = "";
		     FAdt_FecNac.value = "";
         while(FAnv_FiscalColonia.options.length > 0){
           FAnv_FiscalColonia.remove(0);
         }
         Cliente.value = "";
       }

       function Aceptar(e){
         var elementos = document.getElementById("my-form").elements;
         var valor = 0;
         for(var i = 0, element; element = elementos[i++];){
           if(element.id != "FAnv_FiscalCd" && element.type != "button" && element.value === ""){
             element.style.borderColor = "red";
             $("#"+element.id).fadeTo(200, .1).fadeTo(200, 1)
                              .fadeTo(200, .1).fadeTo(200, 1);

             const Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
               timer: 3000,
               didOpen: (toast) => {
                 toast.addEventListener('mouseenter', Swal.stopTimer)
                 toast.addEventListener('mouseleave', Swal.resumeTimer)
               }
             });

             Toast.fire({
               icon: 'error',
               title: 'Rellene todos los campos para continuar.'
             });
             valor ++;
           }
           else{
             element.style.borderColor = "#d6d6d6";
           }
         }
         console.log(valor);

         
       }

       function Tecla(e){
         if(e.code === "Enter"){
           Traer();
         }
       }

       function Traer(e){
         $.ajax({
           url: 'http://127.0.0.1:8000/api/clientes/traer',
           type: 'GET',
           data: {FAnv_Nombres: FAnv_Nombres.value, FAnv_APaterno: FAnv_APaterno.value, FAnv_AMaterno: FAnv_AMaterno.value},
           success: function(respuesta){
             if(respuesta.length == 0){
               const Toast = Swal.mixin({
                 toast: true,
                 position: 'top-end',
                 showConfirmButton: false,
                 timer: 2000,
                 didOpen: (toast) => {
                   toast.addEventListener('mouseenter', Swal.stopTimer)
                   toast.addEventListener('mouseleave', Swal.resumeTimer)
                 }
               });

               Toast.fire({
                 icon: 'error',
                 title: 'El cliente que busca no existe.'
               });
               }
             else{
               Colonos = respuesta[0].FAnv_FiscalColonia;
               FAnv_Nombres.value = respuesta[0].FAnv_Nombres;
		           FAnv_APaterno.value = respuesta[0].FAnv_APaterno;
		           FAnv_AMaterno.value = respuesta[0].FAnv_AMaterno;
		           FAnv_FiscalCd.value = respuesta[0].FAnv_FiscalCd;
               FAnv_ApartadoPost.value = respuesta[0].FAnv_ApartadoPost;
               Colonias();
		           FAnv_Calle.value = respuesta[0].FAnv_Calle;
		           FAnv_Tel.value = respuesta[0].FAnv_Tel;
		           FAnv_Cel.value = respuesta[0].FAnv_Cel;
		           FAnv_CURP.value = respuesta[0].FAnv_CURP;
		           FAnv_RFC.value = respuesta[0].FAnv_RFC;
		           FAnv_IFE.value = respuesta[0].FAnv_IFE;
		           FAdt_FecNac.value = respuesta[0].FAdt_FecNac;
               Cli = respuesta[0].FAnv_Nombres + ' ' + respuesta[0].FAnv_APaterno + ' ' + respuesta[0].FAnv_AMaterno;
             }
           },
           error: function() {
             const Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
               timer: 3000,
               didOpen: (toast) => {
                 toast.addEventListener('mouseenter', Swal.stopTimer)
                 toast.addEventListener('mouseleave', Swal.resumeTimer)
               }
             });

             Toast.fire({
               icon: 'error',
               title: 'No es posible completar la operación.'
             });
             FAnv_Nombres.background = "#f3431e";
           }
         });
       }

       function Colonias(e){
         if(FAnv_ApartadoPost.value.length == 5){
            $.ajax({
              url: 'http://127.0.0.1:8000/api/clientes/colonias',
              type: 'GET',
              data:{CP: FAnv_ApartadoPost.value},
              success: function(respuesta){
                for(i = 0; i < respuesta.length; i++){
                  var option = document.createElement("option");
                      option.text = respuesta[i];
                      FAnv_FiscalColonia.add(option);
                }
                if(typeof Colonos === 'undefined'){
                  FAnv_FiscalColonia.selectedIndex = "0";
                }
                else{
                  FAnv_FiscalColonia.value = Colonos;
                }
              },
              error: function() {
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                });

                Toast.fire({
                  icon: 'error',
                  title: 'No es posible completar la operación.'
                });
              }
            });
         }
         else{
           while(FAnv_FiscalColonia.options.length > 0){
             FAnv_FiscalColonia.remove(0);
           }
         }
       }
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
