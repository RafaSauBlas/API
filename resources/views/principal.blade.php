<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagina principal</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="../css/Estail.css" rel="stylesheet">
  </head>
  <body onload="Limpiar()">
    <br>
    <div class="container" id="Contenedor">
      <br>
      <div class="row">
        <div class="col-2">
          # Distrib
        </div>
        <div class="col-4">
          Distribuidor
        </div>
        <div class="col-4">
          No. Referencia
        </div>
      </div>

      <div class="row">
        <div class="col-2">
          <input type="text" class="form-control" value="250513" Disabled>
        </div>
        <div class="col-4">
          <input type="text" class="form-control" value="VICTOR ESCOBEDO MORALES" Disabled>
        </div>
        <div class="col-4">
          <input type="text" class="form-control" value="351233" Disabled>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-6">
          Cliente
        </div>
        <div class="col-3">
          Vale
        </div>
        <div class="col-3">
          Saldo
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2" id="Cliente" placeholder="Cliente" Disabled>
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="/../Iconos/lupa.png" width="25px" height="25px"></button>
          </div>
        </div>
        <div class="col-3">
          <input type="text" class="form-control" value="191501" Disabled>
        </div>
        <div class="col-3">
          <input type="text" class="form-control" value="$15,000" Disabled>
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-3">
          Sub total
        </div>
        <div class="col-3">
          Descuento
        </div>
        <div class="col-3">
          Total
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          <input type="text" class="form-control" value="$1,000" Disabled>
        </div>
        <div class="col-3">
          <input type="text" class="form-control" value="10%" Disabled>
        </div>
        <div class="col-3">
          <input type="text" class="form-control" value="$900" Disabled>
        </div>
      </div>

      <br>
      <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2">
          <button type="button" class="btn btn-success"><img src="/../Iconos/palomita.png" width="30px" height="25px"></button>
        </div>
      </div>
      <br>
    </div>








    <!-- ========== Modal ========== -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Clientes</h5>
            <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
          </div>
          <div class="modal-body" id="Cuerpo">
            <form id="my-form">
              <div class="container">

                <div class="row">
                  <div class="col-3 col-sm-3">
                    Nombres
                  </div>
                  <div class="col-3 col-sm-3">
                    Ap. Paterno
                  </div>
                  <div class="col-3 col-sm-3">
                    Ap. Materno
                  </div>
                  <div class="col-3 col-sm-3">
                    Fecha de nacimiento
                  </div>
                </div>

                <div class="row">
                  <div class="col-3 col-sm-3">
                    <input type="text" class="form-control" id="FAnv_Nombres" for="validationCustomUsername" onKeyUp="this.value = this.value.toUpperCase();" Required>
                  </div>
                  <div class="col-3 col-sm-3">
                    <input type="text" class="form-control" id="FAnv_APaterno" for="validationCustomUsername" onKeyUp="this.value = this.value.toUpperCase();" Required>
                  </div>
                  <div class="col-3 col-sm-3">
                    <input type="text" class="form-control" id="FAnv_AMaterno" for="validationCustomUsername" onKeyUp="this.value = this.value.toUpperCase();" Required>
                  </div>
                  <div class="col-3 col-sm-3">
                    <input type="date" class="form-control" id="FAdt_FechaNac" for="validationCustomUsername" Required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-4 col-sm-4">
                    CURP
                  </div>
                  <div class="col-4 col-sm-4">
                    RFC
                  </div>
                  <div class="col-4 col-sm-4">
                    INE
                  </div>
                </div>

                <div class="row">
                  <div class="col-4 col-sm-4">
                    <input type="text" class="form-control" id="FAnv_CURP" onKeyUp="this.value = this.value.toUpperCase();">
                  </div>
                  <div class="col-4 col-sm-4">
                    <input type="text" class="form-control" id="FAnv_RFC" onKeyUp="this.value = this.value.toUpperCase();">
                  </div>
                  <div class="col-4 col-sm-4">
                    <input type="text" class="form-control" id="FAnv_IFE" onKeyUp="this.value = this.value.toUpperCase();">
                  </div>
                </div>

                <div class="row">
                  <div class="col-3 col-sm-3">
                    CP
                  </div>
                  <div class="col-3 col-sm-3">
                    Colonia
                  </div>
                  <div class="col-4 col-sm-4">
                    Calle
                  </div>
                  <div class="col-2 col-sm-2">
                    Ciudad
                  </div>
                </div>

                <div class="row">
                  <div class="col-3 col-sm-3">
                    <input type="text" class="form-control" id="FAnv_ApartadoPost" onkeypress="return Restric(event);">
                  </div>
                  <div class="col-3 col-sm-3">
                    <select class="form-select" id="FAnv_FiscalColonia" onfocus="Colonias()">
                    </select>
                  </div>
                  <div class="col-4 col-sm-4">
                    <input type="text" class="form-control" id="FAnv_Calle" onKeyUp="this.value = this.value.toUpperCase();">
                  </div>
                  <div class="col-2 col-sm-2">
                    <input type="text" class="form-control" id="FAnv_FiscalCd" Disabled>
                  </div>
                </div>

                <div class="row">
                  <div class="col-4 col-sm-4">
                    Telefono
                  </div>
                  <div class="col-4 col-sm-4">
                    Celular
                  </div>
                </div>

                <div class="row">
                  <div class="col-4 col-sm-4">
                    <input type="text" class="form-control" id="FAnv_Tel" onkeypress="return Restric(event);">
                  </div>
                  <div class="col-4 col-sm-4">
                    <input type="text" class="form-control" id="FAnv_Cel" onkeypress="return Restric(event);">
                  </div>
                </div>

                <div class="row">
                  <div class="col-11 col-sm-10 col-sm-10"> </div>
                  <div class="col-1 col-sm-1 col-xms-1">
                    <button type="button" id="limpiar" class="btn btn-warning float-right"> <img src="/../Iconos/clean.png" width="25px" height="25px"> </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> <img src="/../Iconos/tache.png" width="25px" height="25px"> </button>
            <button type="button" class="btn btn-success" id="boton" data-placement="bottom"> <img src="/../Iconos/palomita.png" width="25px" height="25px"> </button>
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
       const FAdt_FechaNac = document.getElementById('FAdt_FechaNac');
       const FAnv_Calle = document.getElementById('FAnv_Calle');
       const FAnv_CURP = document.getElementById('FAnv_CURP');
       const FAnv_Tel = document.getElementById('FAnv_Tel');
       const FAnv_Cel = document.getElementById('FAnv_Cel');
       const FAnv_RFC = document.getElementById('FAnv_RFC');
       const FAnv_IFE = document.getElementById('FAnv_IFE');
       const limpiar = document.getElementById('limpiar');
       const Cliente = document.getElementById('Cliente');
       const boton = document.getElementById('boton');
       const Modal = document.getElementById('exampleModal');
       var Colonos;
       var Cli;

       FAnv_ApartadoPost.addEventListener('keyup', Colonias);
       FAnv_AMaterno.addEventListener('keyup', Tecla);
       limpiar.addEventListener('click', Limpiar);
       boton.addEventListener('click', Aceptar);

       function Mayusculas(obj, id){
         obj = obj.toUpperCase();
         document.getElementById(id).value = obj;
       }

       Modal.addEventListener('shown.bs.modal', function (){
         FAnv_Nombres.select();
       });

       function Limpiar(e){
         FAnv_Nombres.value = '';
         FAnv_Nombres.style.borderColor = '#d6d6d6';
         FAnv_APaterno.value = '';
         FAnv_APaterno.style.borderColor = '#d6d6d6';
         FAnv_AMaterno.value = '';
         FAnv_AMaterno.style.borderColor = '#d6d6d6';
         FAnv_FiscalCd.value = '';
         FAnv_FiscalCd.style.borderColor = '#d6d6d6';
         FAnv_ApartadoPost.value = '';
         FAnv_ApartadoPost.style.borderColor = '#d6d6d6';
         FAnv_Calle.value = '';
         FAnv_Calle.style.borderColor = '#d6d6d6';
         FAnv_Tel.value = '';
         FAnv_Tel.style.borderColor = '#d6d6d6';
         FAnv_Cel.value = '';
         FAnv_Cel.style.borderColor = '#d6d6d6';
         FAnv_CURP.value = '';
         FAnv_CURP.style.borderColor = '#d6d6d6';
         FAnv_RFC.value = '';
         FAnv_RFC.style.borderColor = '#d6d6d6';
         FAnv_IFE.value = '';
         FAnv_IFE.style.borderColor = '#d6d6d6';
         FAdt_FechaNac.value = '';
         FAdt_FechaNac.style.borderColor = '#d6d6d6';
         FAnv_FiscalColonia.style.borderColor = '#d6d6d6';
         while(FAnv_FiscalColonia.options.length > 0){
           FAnv_FiscalColonia.remove(0);
         }
         Cliente.value = '';
       }

       function Aceptar(e){
         var elementos = document.getElementById('my-form').elements;
         var valor = 0;
         var Clien;
         for(var i = 0, element; element = elementos[i++];){
           if(element.id != 'FAnv_FiscalCd' && element.type != 'button' && element.value === ''){
             element.style.borderColor = 'red';
             $('#'+element.id).fadeTo(200, .1).fadeTo(200, 1)
                              .fadeTo(200, .1).fadeTo(200, 1);

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
               title: 'Rellene todos los campos para continuar.'
             });
             valor ++;
           }
           else{
             element.style.borderColor = '#d6d6d6';
           }
         }
         
         if(valor == 0){
           $.ajax({
             url: 'http://127.0.0.1:8000/api/clientes/verificar',
             type: 'POST',
             data:{FAnv_Nombres: FAnv_Nombres.value, FAnv_APaterno: FAnv_APaterno.value, FAnv_AMaterno: FAnv_AMaterno.value, FAnv_FiscalCd: FAnv_FiscalCd.value,
	                 FAnv_FiscalColonia: FAnv_FiscalColonia.value, FAnv_ApartadoPost: FAnv_ApartadoPost.value, FAnv_Calle: FAnv_Calle.value, FAnv_Tel: FAnv_Tel.value,
	                 FAnv_Cel: FAnv_Cel.value, FAnv_CURP: FAnv_CURP.value, FAnv_RFC: FAnv_RFC.value, FAnv_IFE: FAnv_IFE.value, FAdt_FechaNac: FAdt_FechaNac.value},
             success: function(respuesta){
               if(respuesta != ""){
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
                   icon: 'success',
                   title: respuesta
                 });

               }
               Clien = FAnv_Nombres.value + ' ' + FAnv_APaterno.value + ' ' + FAnv_AMaterno.value;
               Cliente.value = Clien;
               $('#exampleModal').modal('hide');
             },
             error: function(){
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
                 title: 'No es posible completar la operación.'
               });
             }
           });
         }
         
       }
       
       function Tecla(e){
         if(e.code === 'Enter'){
           Traer();
         }
       }

       //FUNCTION PARA SOLO ADMITIR NUMEROS EN LOS INPUTS DE LOS TELEFONOS
       function Restric(e){
         var code = (e.which) ? e.which : e.code;
           if(code == 8){
             return true;
           } else if(code >= 48 && code <= 57){
             return true;
           } else{
             return false;
           }
       }

       function Traer(e){
        //Este metodo es para limpiar el select del CP
        while(FAnv_FiscalColonia.options.length > 0){
          FAnv_FiscalColonia.remove(0);
        }

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
               FAdt_FechaNac.value = respuesta[0].FAdt_FechaNac;
               Cli = respuesta[0].FAnv_Nombres + ' ' + respuesta[0].FAnv_APaterno + ' ' + respuesta[0].FAnv_AMaterno;
             }
           },
           error: function(){
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
               title: 'No es posible completar la operación.'
             });

           }
         });
       }
       
       function Ciudad(e){
         $.ajax({
           url: 'http://127.0.0.1:8000/api/clientes/Municipio',
           type: 'GET',
           data:{CP: FAnv_ApartadoPost.value},
             success: function(respuesta){
               FAnv_FiscalCd.value = respuesta;
             },
             error: function() {
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
                 title: 'No es posible completar la operación.'
               });
             }
         });
       }

       function Colonias(e){
         if(FAnv_ApartadoPost.value.length == 5){
           if(FAnv_FiscalColonia.options.length == 0){
             $.ajax({
               url: 'http://127.0.0.1:8000/api/clientes/colonias',
               type: 'GET',
               data:{CP: FAnv_ApartadoPost.value},
               success: function(respuesta){
                 Ciudad();
                 for(i = 0; i < respuesta.length; i++){
                 var option = document.createElement('option');
                     option.text = respuesta[i];
                     FAnv_FiscalColonia.add(option);
                 }
                 if(typeof Colonos === 'undefined'){
                   FAnv_FiscalColonia.selectedIndex = '0';
                 }
                 else{
                   FAnv_FiscalColonia.value = Colonos;
                 }
               },
               error: function(){
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
                   title: 'No es posible completar la operación.'
                 });
               }
             });
           }
         }
         else{
           while(FAnv_FiscalColonia.options.length > 0){
             FAnv_FiscalColonia.remove(0);
           }
           FAnv_FiscalCd.value = '';
         }
       }
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
