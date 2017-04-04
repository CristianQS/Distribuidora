

function deleteLinea(id){
    if(!confirm("¿Desea borrar la Linea de Pedido?")){
        return;
    }
    $.ajax({
        url: "deleteLinea.php",
        type: 'POST',
        data: JSON.stringify({"id":id}),
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function(resK){
          if(resK.deleted){
             $('#fila'+id).remove();
          }else{
             alert('Error:'+resK.message);
          }
       },
       error: function(resK){
          alert('Error:'+resK);
       }
    });
}


function addLinea(){
    //document.getElementById("tabla").style.display="none";
    
    if(document.getElementById("Población").value.toString() =="" || document.getElementById("Dirección").value.toString() ==""){
        alert("Primero debe crear un pedido");
        return false;
    }
    
  
    var unidades = parseInt(document.getElementById("cantidad").value);
    var marca = document.getElementById("Marca").value;  
    if(!confirm("¿Desea añadir una linea de pedido")){
        return;
    }
    $.ajax({
        url: "addCesta.php",
        type: 'POST',
        data: JSON.stringify({"cantidad":unidades,"Marca":marca}),
        contentType: "application/json;charset=utf-8",
        dataType: "json",
        success: function (resJ) {
            if(resJ.add){
                successmessage = 'Se ha añadido correctamente una linea de pedido';
                alert(successmessage);
                document.getElementById("lineas").style.display="inline";
                var table = document.getElementById("tablaLineas");
                var row = table.insertRow(-1);
                row.id ="fila"+resJ.id;
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                cell1.innerHTML = resJ.marca;
                cell2.innerHTML = resJ.unidades;
                cell3.innerHTML = resJ.PVP;
                cell4.innerHTML = "<button onclick=\"deleteLinea("+ resJ.id+" )\">Borrar</button>";
                
            } else {
                successmessage = 'Introduzca una cantidad válida';
                alert(successmessage);    
                
            }
            
        },
        error: function(resJ) {
             alert('Error:'+resJ.message);
        }
    });
}

function validate(){
    var x = document.forms["formCreateUser"]["nombreUser"].value;
    var boolean = true;
    if (x.toString().length < 4) {
        document.getElementById("error1").innerHTML = "El nombre de usuario debe tener, al menos, 4 carácteres";
        boolean = false;
    } else {
        document.getElementById("error1").innerHTML = "";
    }
    x = document.forms["formCreateUser"]["nombreCom"].value;
    if (x.toString().length < 4) {
        document.getElementById("error2").innerHTML = "El nombre completo debe tener, al menos, 4 carácteres";
        boolean = false;
    } else {
        document.getElementById("error2").innerHTML = "";
    }
    return boolean;
}

function showAddresInput(){
    var radios = document.getElementsByName('tipo');
    if(radios[1].checked){
        document.getElementById("camposCliente").style.display = "inline";
    } else {
        document.getElementById("camposCliente").style.display = "none";
    }
    
}

