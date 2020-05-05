$(document).ready(function() {

    incializarVariables();
    detectOperativeSystem();
    //Submit evento
    $('#submit').click(function(e){
        e.preventDefault();
        submitButton = document.getElementById('submit');
        submitButton.disabled = true;

        dataForm = getDataForm();        

        $.ajax({
            type: "POST",
            url: "../controladores/formulario_controller.php",
            dataType: "json",
            data: dataForm,
            success : function(data) {
                if (data.code == "200"){
                    window.location = '../vistas/banner.php';
                } else {
                    submitButton.disabled = false;
                    setErrorForm(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error: ' + textStatus + ' ' + errorThrown);
            }
        });
    });
    
})

function setErrorForm(data) {
    if (data.errorHabitacion != null) {
        if (data.errorHabitacion) {
            setErrorHabitacion(data);
        }
    }

    if (data.errorVoucher != null) {
        if (data.errorVoucher) {
            setErrorVoucher(data);
        }
    }

    if (data.errorNombre != null) {
        if (data.errorNombre) {
            setErrorNombre(data);
        }
    }

    if (data.errorApellidos != null) {
        if (data.errorApellidos) {
            setErrorApellidos(data);
        }
    }

    if (data.errorCheck != null) {
        if (data.errorCheck) {
            setErrorCheck(data);
        }
    }

    if (data.errorEmail != null) {
        if (data.errorEmail) {
            setErrorEmail(data);
        }
    }

    
    if (data.errorEdad != null) {
        if (data.errorEdad) {
            setErrorEdad(data);
        }
    }

    if (data.errorTelefono != null) {
        if (data.errorTelefono) {
            setErrorTelefono(data);
        }
    }
    
    if (data.errorGenero != null) {
        if (data.errorGenero) {
            setErrorGenero(data);
        }
    }
    if (data.errorRazonVisita != null) {
        if (data.errorRazonVisita) {
            setErrorRazonVisita(data);
        }
    }  
}

function getDataForm() {
    arrayDatosFormulario = {};

    if (document.getElementById('nombre') != null) {
        arrayDatosFormulario['nombre'] = $("#nombre").val();
    }
    if (document.getElementById('apellidos') != null) {
        arrayDatosFormulario['apellidos'] = $("#apellidos").val();
    }
    if (document.getElementById('email') != null) {
        arrayDatosFormulario['email'] = $("#email").val();
    }
    if (document.getElementById('telefono') != null) {
        arrayDatosFormulario['telefono'] = $("#telefono").val();
    }
    if (document.getElementById('genero') != null) {
        arrayDatosFormulario['genero'] = $("#genero").val();
    }    
    if (document.getElementById('num_habitacion') != null) {
        arrayDatosFormulario['num_habitacion'] = $("#num_habitacion").val();
    }
    if (document.getElementById('num_voucher') != null) {
        arrayDatosFormulario['num_voucher'] = $("#num_voucher").val();
    }
    if (document.getElementById('razon_visita') != null) {
        arrayDatosFormulario['razon_visita'] = $("#razon_visita").val();
    }
    if (document.getElementById('edad') != null) {
        arrayDatosFormulario['edad'] = $("#edad").val();
    }
    if (document.getElementById('lang') != null) {
        arrayDatosFormulario['lang'] = $("#lang").val();
    }
    if (document.getElementById('os') != null) {
        arrayDatosFormulario['os'] = $("#os").val();
    }
    if (document.getElementById('customSwitches') != null) {
        arrayDatosFormulario['check'] = $("#customSwitches").is(':checked');;
    }

    return arrayDatosFormulario;
}

function detectOperativeSystem() {
    // Recoleccion sistema Operativo
    var OSName="Otro";
    if (navigator.appVersion.indexOf("Win")!=-1){ OSName="Windows" }
    if (navigator.appVersion.indexOf("Mac")!=-1){ OSName="MacOS" }
    if (navigator.appVersion.indexOf("X11")!=-1){ OSName="UNIX" }
    if (navigator.appVersion.indexOf("Linux")!=-1){ OSName="Linux" }
    if (navigator.appVersion.indexOf("Android")!=-1){ OSName="Android" }
    $("#os").val(OSName);
}

function incializarVariables() {
      //Variables iniciales
      if (document.getElementById("errorMSGHabitacion") != null) {
        var errorHabitacion = document.getElementById("errorMSGHabitacion");
        errorHabitacion.hidden = true;    
      } 
      if (document.getElementById("errorMSGVoucher") != null) {        
        var errorVoucher = document.getElementById("errorMSGVoucher");
        errorVoucher.hidden = true;  
      } 
      if (document.getElementById("errorMSGNombre")) {
        var errorNombre = document.getElementById("errorMSGNombre");
        errorNombre.hidden = true;    
      }
      if (document.getElementById("errorMSGApellidos")) {
        var errorApellidos = document.getElementById("errorMSGApellidos");
        errorApellidos.hidden = true; 
      }
      if (document.getElementById("errorMSGEmail")) {
        var errorEmail = document.getElementById("errorMSGEmail");
        errorEmail.hidden = true; 
      }
      if (document.getElementById("errorMSGTelefono")) {
        var errorTelefono = document.getElementById("errorMSGTelefono");
        errorTelefono.hidden = true; 
      }
      if (document.getElementById("errorMSGEdad")) {
        var errorEdad= document.getElementById("errorMSGEdad");
        errorEdad.hidden = true;   
      }
      if (document.getElementById("errorMSGGenero")) {
        var errorGenero = document.getElementById("errorMSGGenero");
        errorGenero.hidden = true; 
      }      
      if (document.getElementById("errorMSGCheck")) {
        var errorCheck= document.getElementById("errorMSGCheck");
        errorCheck.hidden = true;   
      }
}

function setErrorRazonVisita(data) {
    var spanErrorRazonVisita = document.getElementById("errorMSGRazonVisita");
    spanErrorRazonVisita.textContent = data.errorMSGRazonVisita;
    spanErrorRazonVisita.hidden = false;
    var formGroupRazonVisita = document.getElementById("form_group_razon_visita");
    formGroupRazonVisita.classList.add("input_error");
}

function setErrorEmail(data) {
    var spanErrorEmail = document.getElementById("errorMSGEmail");
    spanErrorEmail.textContent = data.errorMSGEmail;
    spanErrorEmail.hidden = false;
    var formGroupEmail = document.getElementById("form_group_email");
    formGroupEmail.classList.add("input_error");
}

function setErrorTelefono(data) {
    var spanErrorTelefono = document.getElementById("errorMSGTelefono");
    spanErrorTelefono.textContent = data.errorMSGTelefono;
    spanErrorTelefono.hidden = false;
    var formGroupTelefono = document.getElementById("form_group_telefono");
    formGroupTelefono.classList.add("input_error");
}

function setErrorEdad(data) {
    var spanErrorEdad = document.getElementById("errorMSGEdad");
    spanErrorEdad.textContent = data.errorMSGEdad;
    spanErrorEdad.hidden = false;
    var formGroupEdad = document.getElementById("form_group_edad");
    formGroupEdad.classList.add("input_error");
}

function setErrorGenero(data) {
    var spanErrorGenero = document.getElementById("errorMSGGenero");
    spanErrorGenero.textContent = data.errorMSGGenero;
    spanErrorGenero.hidden = false;
    var formGroupGenero= document.getElementById("form_group_genero");
    formGroupGenero.classList.add("input_error");
}

function setErrorHabitacion(data) {
    var spanErrorHabitacion = document.getElementById("errorMSGHabitacion");
    spanErrorHabitacion.textContent = data.errorMSGHabitacion;
    spanErrorHabitacion.hidden = false;
    var formGroupHabitacion = document.getElementById("form_group_habitacion");
    formGroupHabitacion.classList.add("input_error");
}

function setErrorVoucher(data) {
    var spanErrorVoucher = document.getElementById("errorMSGVoucher");
    spanErrorVoucher.hidden = false;
    spanErrorVoucher.textContent = data.errorMSGVoucher;
    var formGroupVoucher = document.getElementById("form_group_voucher");
    formGroupVoucher.classList.add("input_error");
}

function setErrorNombre(data) {
    var spanErrorNomnbre = document.getElementById("errorMSGNombre");
    spanErrorNomnbre.hidden = false;
    spanErrorNomnbre.textContent = data.errorMSGNombre;
    var formGroupNombre = document.getElementById("form_group_nombre");
    formGroupNombre.classList.add("input_error");
}

function setErrorApellidos(data) {
    var spanErrorApellidos = document.getElementById("errorMSGApellidos");
    spanErrorApellidos.hidden = false;
    spanErrorApellidos.textContent = data.errorMSGApellidos;
    var formGroupApellidos = document.getElementById("form_group_apellidos");
    formGroupApellidos.classList.add("input_error");
}

function setErrorCheck(data) {
    var spanErrorCheck = document.getElementById("errorMSGCheck");
    spanErrorCheck.hidden = false;
    spanErrorCheck.textContent = data.errorMSGCheck;
    var formGroupCheck = document.getElementById("form_group_check");
    formGroupCheck.classList.add("input_error");
}



function quitErrorRazonVisita() {    
    var formGroupRazonVisita = document.getElementById("form_group_razon_visita");
    if (formGroupRazonVisita.classList.contains("input_error")) {
        formGroupRazonVisita.classList.remove("input_error");
        var inputRazonVisita = document.getElementById("razon_visita");
        inputRazonVisita.value = "";
        var spanErrorRazonVisita = document.getElementById("errorMSGRazonVisita");
        if(spanErrorRazonVisita != null) {
            spanErrorRazonVisita.textContent = "";
            spanErrorRazonVisita.hidden = true;
        }        
    }   
    
}

function quitErrorHabitacion() {    
    var formGroupHabitacion = document.getElementById("form_group_habitacion");
    if (formGroupHabitacion.classList.contains("input_error")) {
        formGroupHabitacion.classList.remove("input_error");
        var inputHabitacion = document.getElementById("num_habitacion");
        inputHabitacion.value = "";
        var spanErrorHabitacion = document.getElementById("errorMSGHabitacion");
        if(spanErrorHabitacion != null) {
            spanErrorHabitacion.textContent = "";
            spanErrorHabitacion.hidden = true;
        }        
    }   
    
}

function quitErrorVoucher() {
    var formGroupVoucher = document.getElementById("form_group_voucher");
    if (formGroupVoucher.classList.contains("input_error")) {
        formGroupVoucher.classList.remove("input_error");
        var inputVoucher= document.getElementById("num_voucher");
        inputVoucher.value = "";
        var spanErrorVoucher = document.getElementById("errorMSGVoucher");
        if(spanErrorVoucher != null) {
            spanErrorVoucher.hidden = true;
            spanErrorVoucher.textContent = "";
        }  
    }
}


function quitErrorNombre() {
    var formGroupNombre = document.getElementById("form_group_nombre");
    if (formGroupNombre.classList.contains("input_error")) {
        formGroupNombre.classList.remove("input_error");
        var inputNombre= document.getElementById("nombre");
        inputNombre.value = "";
        var spanErrorNombre = document.getElementById("errorMSGNombre");
        if(spanErrorNombre != null) {
            spanErrorNombre.hidden = true;
            spanErrorNombre.textContent = "";
        }  
    }
}


function quitErrorApellidos() {
    var formGroupApellidos = document.getElementById("form_group_apellidos");
    if (formGroupApellidos.classList.contains("input_error")) {
        formGroupApellidos.classList.remove("input_error");
        var inputApellidos= document.getElementById("apellidos");
        inputApellidos.value = "";
        var spanErrorApellidos = document.getElementById("errorMSGApellidos");
        if(spanErrorApellidos != null) {
            spanErrorApellidos.hidden = true;
            spanErrorApellidos.textContent = "";
        }  
    }
}

function quitErrorEdad() {
    var formGroupEdad = document.getElementById("form_group_edad");
    if (formGroupEdad.classList.contains("input_error")) {
        formGroupEdad.classList.remove("input_error");
        var inputEdad = document.getElementById("edad");
        inputEdad.value = "";
        var spanErrorEdad = document.getElementById("errorMSGEdad");
        if(spanErrorEdad != null) {
            spanErrorEdad.hidden = true;
            spanErrorEdad.textContent = "";
        }  
    }
}


function quitErrorEmail() {
    var formGroupEmail = document.getElementById("form_group_email");
    if (formGroupEmail.classList.contains("input_error")) {
        formGroupEmail.classList.remove("input_error");
        var inputEmail = document.getElementById("email");
        inputEmail.value = "";
        var spanErrorEmail = document.getElementById("errorMSGEmail");
        if(spanErrorEmail != null) {
            spanErrorEmail.hidden = true;
            spanErrorEmail.textContent = "";
        }  
    }
}

function quitErrorTelefono() {
    var formGroupTelefono = document.getElementById("form_group_telefono");
    if (formGroupTelefono.classList.contains("input_error")) {
        formGroupTelefono.classList.remove("input_error");
        var inputTelefono = document.getElementById("telefono");
        inputTelefono.value = "";
        var spanErrorTelefono = document.getElementById("errorMSGTelefono");
        if(spanErrorTelefono != null) {
            spanErrorTelefono.hidden = true;
            spanErrorTelefono.textContent = "";
        }  
    }
}

function quitErrorGenero() {
    var formGroupGenero = document.getElementById("form_group_genero");
    if (formGroupGenero.classList.contains("input_error")) {
        formGroupGenero.classList.remove("input_error");
        var inputGenero = document.getElementById("genero");
        inputGenero.value = "";
        var spanErrorGenero = document.getElementById("errorMSGGenero");
        if(spanErrorGenero != null) {
            spanErrorGenero.hidden = true;
            spanErrorGenero.textContent = "";
        }  
    }
}

function quitErrorCheck() {
    var formGroupCheck = document.getElementById("form_group_check");
    if (formGroupCheck.classList.contains("input_error")) {
        formGroupCheck.classList.remove("input_error");       
        var spanErrorCheck = document.getElementById("errorMSGCheck");
        if(spanErrorCheck != null) {
            spanErrorCheck.hidden = true;
            spanErrorCheck.textContent = "";
        }  
    }  
}

function restaurarInputRazonVisita() {
    quitErrorRazonVisita();
}

function restaurarInputEmail() {
    quitErrorEmail();   
}

function restaurarInputTelefono() {
    quitErrorTelefono();  
}

function restaurarInputEdad() {
    quitErrorEdad();   
}

function restaurarInputGenero() {
    quitErrorGenero();
}

function restaurarInputHabitacion() {
    quitErrorHabitacion();
}

function restaurarInputVoucher() {
    quitErrorVoucher();
}

function restaurarInputNombre() {
    quitErrorNombre();
}

function restaurarInputApellidos() {
    quitErrorApellidos();
}

function restaurarInputCheck() {
    quitErrorCheck();
}

function dropInvalidCharactersNombre() {
    var element = document.getElementById('nombre');
    element.value = element.value.replace(/[^a-zA-Z0\s]+/, '');
};

function dropInvalidCharactersApellidos() {
    var element = document.getElementById('apellidos');
    element.value = element.value.replace(/[^a-zA-Z0\s]+/, '');
};

function dropInvalidCharactersHabitacion() {
    var element = document.getElementById('num_habitacion');
    element.value = element.value.replace(/[^0-9\s]+/, '');
};

function dropInvalidCharactersAge() {
    var element = document.getElementById('edad');
    element.value = element.value.replace(/[^0-9\s]+/, '');
}

function dropInvalidCharactersTelefono() {
    var element = document.getElementById('telefono');
    element.value = element.value.replace(/[^0-9\s]+/, '');
}



