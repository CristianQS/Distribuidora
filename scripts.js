
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
        success: function(res){
            if(res.deleted){
                $('#fila'+id).remove();
            }else{
                error(res.message);
            }
        },
        error: function(res){
            error(res);
        }
    });
}

function compruebaUsuario(){
    var user = document.getElementById("nombreUser").value;
    var nombre = document.getElementById("nombreCom").value;
    var comprueba = validar(user,nombre);
    return comprueba;
}

function validar(userName, nameComplete){
    var boolean = true;
    if(userName.toString().length < 4){
        alert("El nombre usuario debe tener al menos 4 caracteres");
        boolean=false;
    }
    if(nameComplete.toString().length < 4){
        alert("El nombre completo debe tener al menos 4 caracteres");
        boolean= false;
    }
    return boolean;
}

function addLinea(){
    
        var unidades = parseInt(document.getElementById("cantidad").value);
    if (Number.isInteger(unidades) && unidades > 0) {
        document.getElementById("drinkQuantityDiv").style.display = "none";
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState== 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                if(res.added === true){
                    var tabla = document.getElementById("itemOrderTable");
                    var fila = tabla.insertRow(-1);
                    fila.id = "fila" + res.id;
                    var celdaId = fila.insertCell(0);
                    celdaId.innerHTML = res.id;
                    var celdaBebida = fila.insertCell(1);
                    celdaBebida.innerHTML = res.bebida;
                    var celdaUnidades = fila.insertCell(2);
                    celdaUnidades.innerHTML = res.unidades;
                    var celdaPvp = fila.insertCell(3);
                    celdaPvp.innerHTML = res.pvpbebida;
                    var celdaAccion = fila.insertCell(4);
                    celdaAccion.innerHTML = "<input type='button' value='Eliminar' onclick='deleteItemByID(" + res.id + ", \"" + res.bebida + "\");' />";
                    document.getElementById('pvpTotal').innerHTML = res.pvp;
                }
            }
        };
        ajax.open("get","addCesta.php",true);
        ajax.setRequestHeader("Content-Type","application/json;charset=UTF-8");
        ajax.send(JSON.stringify({"Marca":marca,"cantidad":unidades}));
    } else {
        document.getElementById("drinkQuantityDiv").innerHTML = "Introduce un número entero positivo";
        document.getElementById("drinkQuantityDiv").style.display = "";
    }
    
    console.log(document.getElementById("Marca").value);
    console.log(document.getElementById("cantidad").value);
   //    
    var unidades = document.getElementById("cantidad").value;
    var marca = document.getElementById("Marca").value;
    }
     