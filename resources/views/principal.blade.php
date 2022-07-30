<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Cliente
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Clientes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
          
          <div class="container">
            <br>
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
                <input type="text" class="form-control" id="FAnv_Nombres">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="FAnv_APaterno">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="FAnv_AMaterno">
              </div>
              <div class="col-3">
                <input type="date" class="form-control" id="FAdt_FecNac">
              </div>
            </div>
            <br>

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
                <input type="text" class="form-control" id="FAnv_FiscalCd">
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
          </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="boton">Aceptar</button>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
       const FAnv_Nombres = document.getElementById('FAnv_Nombres');
	   const FAnv_APaterno = document.getElementById('FAnv_APaterno');
	   const FAnv_AMaterno = document.getElementById('FAnv_AMaterno');
	   const FAnv_FiscalCd = document.getElementById('FAnv_FiscalCd');
	   const FAnv_FiscalColonia = document.getElementById('FAnv_FiscalColonia');
	   const FAnv_ApartadoPost = document.getElementById('FAnv_ApartadoPost');
	   const FAnv_Calle = document.getElementById('FAnv_Calle');
	   const FAnv_Tel = document.getElementById('FAnv_Tel');
	   const FAnv_Cel = document.getElementById('FAnv_Cel');
	   const FAnv_CURP = document.getElementById('FAnv_CURP');
	   const FAnv_RFC = document.getElementById('FAnv_RFC');
	   const FAnv_IFE = document.getElementById('FAnv_IFE');
	   const FAdt_FecNac = document.getElementById('FAdt_FecNac');
       const boton = document.getElementById('boton');
       var Colonos;

       FAnv_AMaterno.addEventListener('keyup', Tecla);
       FAnv_ApartadoPost.addEventListener('change', Colonias);
       boton.addEventListener('click', Traer);

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
                })

                Toast.fire({
                  icon: 'error',
                  title: 'No es posible completar la operación.'
                });
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
                  FAnv_FiscalColonia.value = Colonos;
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
                  })

                  Toast.fire({
                     icon: 'error',
                     title: 'No es posible completar la operación.'
                  });
               }
            });
         }
       }

    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
