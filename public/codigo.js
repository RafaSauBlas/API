       const documento = document.createElement("documento");
       documento.href = "/../resources/views/principal.blade.php";
       documento.target = "principal.blade.php";

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
         FAnv_Nombres.style.borderColor = "#d6d6d6";
         FAnv_APaterno.value = "";
         FAnv_APaterno.style.borderColor = "#d6d6d6";
         FAnv_AMaterno.value = "";
         FAnv_AMaterno.style.borderColor = "#d6d6d6";
         FAnv_FiscalCd.value = "";
         FAnv_FiscalCd.style.borderColor = "#d6d6d6";
         FAnv_ApartadoPost.value = "";
         FAnv_ApartadoPost.style.borderColor = "#d6d6d6";
         FAnv_Calle.value = "";
         FAnv_Calle.style.borderColor = "#d6d6d6";
         FAnv_Tel.value = "";
         FAnv_Tel.style.borderColor = "#d6d6d6";
         FAnv_Cel.value = "";
         FAnv_Cel.style.borderColor = "#d6d6d6";
         FAnv_CURP.value = "";
         FAnv_CURP.style.borderColor = "#d6d6d6";
         FAnv_RFC.value = "";
         FAnv_RFC.style.borderColor = "#d6d6d6";
         FAnv_IFE.value = "";
         FAnv_IFE.style.borderColor = "#d6d6d6";
         FAdt_FechaNac.value = "";
         FAdt_FechaNac.style.borderColor = "#d6d6d6";
         FAnv_FiscalColonia.style.borderColor = "#d6d6d6";
         while(FAnv_FiscalColonia.options.length > 0){
           FAnv_FiscalColonia.remove(0);
         }
         Cliente.value = "";
       }

       function Aceptar(e){
         var elementos = documento.getElementById("my-form").elements;
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
             element.style.borderColor = "#d6d6d6";
           }
         }

         if(valor == 0){
           $.ajax({
             url: 'http://127.0.0.1:8000/api/clientes/verificar',
             type: 'GET',
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

                 Cliente.value = FAnv_Nombres.value.toUpperCase()+' '+FAnv_APaterno.value.toUpperCase()+' '+FAnv_AMaterno.value.toUpperCase();
               }
               $("#exampleModal").modal('hide');
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
           Cliente.value = Cli;
         }
         
       }

       function Tecla(e){
         if(e.code === "Enter"){
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

       function Ciudad(e){
         if(FAnv_ApartadoPost.value.length == 5){
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
                 title: 'No es posible completar la operación'
               })
             }
           });
         }
         else{
           while(FAnv_FiscalColonia.options.length > 0){
             FAnv_FiscalColonia.remove(0);
           }
         }
       }

       function Colonias(e){
         while(FAnv_FiscalColonia.options.length > 0){
           FAnv_FiscalColonia.remove(0);
         }

         if(FAnv_ApartadoPost.value.length == 5){
           $.ajax({
             url: 'http://127.0.0.1:8000/api/clientes/colonias',
             type: 'GET',
             data:{CP: FAnv_ApartadoPost.value},
             success: function(respuesta){
               Ciudad();
               for(i = 0; i < respuesta.length; i++){
                 var option = documento.createElement("option");
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