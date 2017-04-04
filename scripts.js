
function deleteLinea(id){
    if(!confirm("¿Desea borrar la Linea de Pedido?")){
        return;
    }
    $.ajax({
        url: "deleteLinea.php",
        type: 'POST',
        data: JSON.stringify({"id":id}),
        contentType: "application/json;charset=utf-8",
        dataType: "json"
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
    if(!confirm("¿Desea añadir una Linea de Pedido?")){
        return;
    }
    
    var unidades = parseInt(document.getElementById("cantidad").value);
    var marca = document.getElementById("Marca").value;
    console.log(unidades);
    console.log(marca);
    $.ajax({
        url: "addCesta.php",
        type: 'POST',
        data: JSON.stringify({"cantidad":unidades,"Marca":marca}),
        contentType: "application/json;charset=utf-8",
        dataType: "json"
    });
}
    

     