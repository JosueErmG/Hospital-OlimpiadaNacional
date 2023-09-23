document.addEventListener('DOMContentLoaded', () => {
    for (const el of document.querySelectorAll("[data-mask][data-slots]")) {
        var pattern = el.getAttribute("data-mask"),
            slots = new Set(el.dataset.slots || "_"),
            prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
            first = [...pattern].findIndex(c => slots.has(c));
        const accept = new RegExp(el.dataset.accept || "\\d", "g"),
            clean = input => {
                input = input.match(accept) || [];
                return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                );
            },
            format = () => {
                const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                    i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                    return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                });
                pattern = el.getAttribute("data-mask");
                slots = new Set(el.dataset.slots || "_");
                prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0);
                first = [...pattern].findIndex(c => slots.has(c));

                el.value = clean(el.value).join``;
                el.setSelectionRange(i, j);
                back = false;
            };
        let back = false;
        el.addEventListener("keydown", (e) => back = e.key === "Backspace");
        el.addEventListener("input", format);
        el.addEventListener("focus", format);
        el.addEventListener("blur", () => el.value === pattern && (el.value=""));
    }
});

function IntOrSubmit(e, oText) {
    if (e.keyCode == 13) {
        oText.form.submit();
        e.preventDefault();
    }
    else if (isNaN(e.key))
        e.preventDefault();
}

function ChangeInput(e, oImp, value, min = -1, max = -1) {
    var oImp = document.getElementById(oImp);

    if (!(typeof value === "number")) {
        if (value.substring(0, 1) == "+")
            value = parseInt(oImp.value) + parseInt(value.substring(1));
        else if (value.substring(0, 1) == "-")
            value = parseInt(oImp.value) - parseInt(value.substring(1));
    }

    if (max != -1)
        value = Math.min(value, max);
    if (min != -1)
        value = Math.max(min, value);

    if (oImp.value != value)
        oImp.value = value;
    else
        e.preventDefault();
}

function TelephoneInput(e, oText) {
    if (!isNaN(e.key) && (isNaN(e.key) || (oText.getAttribute("data-mask").match(/_/g) || []).length > 15))
        e.preventDefault();
    else {
        var count = (oText.value.match(/\d/g) || []).length - (e.keyCode == 8) + !isNaN(e.key);
        if (count <= 12)
            oText.setAttribute("data-mask", "+__ ___ ___-____");
        else if (count == 13) {
            oText.setAttribute("data-mask", "+__ ___ ____-____");
        }
        else if (count == 14)
            oText.setAttribute("data-mask", "+___ ___ ____-____");
        else
            oText.setAttribute("data-mask", "+___ ____ ____-____");
    }
}

function DtDelete(oBtn, table, column) {
    var row = oBtn.id.substring(oBtn.id.lastIndexOf('_') + 1);
    DBDelete(table, column + ' = ' + row, function(result) {
        if (!result)
            document.getElementById("datatable_row_" + row).remove();
        else {
            alert("Error: " + result);
        }
    })
}

function DBDelete(table, condition, callback) {
    $.ajax({
        type: "POST",
        url: "config/dbdelete.php",
        dataType: "json",
        data: {table: table, condition: condition},
    })
    .done(function(ex) {
        if (!ex) 
            callback(false);
        else {
            console.error("Exception: " + ex);
            callback(ex);
        }
    }).fail(function(){
        callback("Command failed");
    });
}

function CheckPass(pass) {
    var errorStr = "";
    if (pass.length < 8)
        errorStr = "La contraseña debe contener al menos 8 caracteres";
    if (!pass.match(/[a-z]/))
        errorStr += errorStr != "" ? ", una minúscula" : "La contraseña debe contener al menos una minúscula";
    if (!pass.match(/[A-Z]/))
        errorStr += errorStr != "" ? ", una mayúsucula" : "La contraseña debe contener al menos una mayúsucula";
    if (!pass.match(/[\d]/))
        errorStr += errorStr != "" ? ", un número" : "La contraseña debe contener al menos un número";
    if (errorStr != "" && (pos = errorStr.lastIndexOf(", ")) > 0)
        errorStr = errorStr.substring(0, pos) + " y " + errorStr.substring(pos + 2);
    
    return errorStr;
}

function CheckUsersForm() {
    var uFile = document.getElementById("uFile"), uDNI = document.getElementById("uDNI"),
        uName = document.getElementById("uName"), uLastname = document.getElementById("uLastname"),
        uArea = document.getElementById("uArea"),
        uEmail = document.getElementById("uEmail"), uNumber = document.getElementById("uNumber"),
        uPass = document.getElementById("uPass"), rePass = document.getElementById("rePass"),
        errorLabel = document.getElementById("form_error_label"),
        error = "&nbsp";

    if (uFile.value == "") {
        uFile.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uDNI.value == "") {
        uDNI.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uName.value == "") {
        uName.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uLastname.value == "") {
        uLastname.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uArea.value == "") {
        uArea.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uEmail.value == "") {
        uEmail.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uNumber.value == "") {
        uNumber.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (uPass.value == "") {
        uPass.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (rePass.value == "") {
        rePass.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (error == "&nbsp") {
        if (isNaN(uFile.value) || uFile.value < 1 || uFile.value > 99999999) {
            uFile.classList.add("form-input-error");
            error = "Número de legajo inválido";
        }
        else if (isNaN(uDNI.value) || uDNI.value < 999999) {
            uDNI.classList.add("form-input-error");
            error = "Número de documento inválido";
        }
        else if (isNaN(uArea.value) || uArea.value < 1) {
            uArea.classList.add("form-input-error");
            error = "Código de área inválido";
        }
        else if (errorStr = CheckPass(uPass.value)) {
            uPass.classList.add("form-input-error");
            error = errorStr;
        }
        else if (uPass.value != rePass.value) {
            rePass.classList.add("form-input-error");
            error = "Las contraseñas no coinciden";
        }
    }

    CheckUsersFormButton();
    errorLabel.innerHTML = error;
}

function CheckUsersPass() {
    var uPass = document.getElementById("uPass"),
        errorLabel = document.getElementById("form_error_label");

    error = "&nbsp";
    if (uPass.value == "" || !(errorStr = CheckPass(uPass.value))) 
        uPass.classList.remove("form-input-error");
    else {
        uPass.classList.add("form-input-error");
        error = errorStr;
    }

    if (error == "&nbsp")
        CheckUsersRePass();
    else {
        CheckUsersFormButton();
        errorLabel.innerHTML = error;
    }
}

function CheckUsersRePass() {
    var uPass = document.getElementById("uPass"), rePass = document.getElementById("rePass"),
        errorLabel = document.getElementById("form_error_label"),
        error = "&nbsp";

    if (uPass.value == rePass.value)
        rePass.classList.remove("form-input-error");
    else {
        rePass.classList.add("form-input-error");
        error = "Las contraseñas no coinciden";
    }

    CheckUsersFormButton();
    errorLabel.innerHTML = error;
}

function CheckUsersFormButton() {
    var uFile = document.getElementById("uFile"), uDNI = document.getElementById("uDNI"),
        uName = document.getElementById("uName"), uLastname = document.getElementById("uLastname"),
        uArea = document.getElementById("uArea"),
        uEmail = document.getElementById("uEmail"), uNumber = document.getElementById("uNumber"),
        uPass = document.getElementById("uPass"), rePass = document.getElementById("rePass"),
        button = document.getElementById("submit");
    
    button.disabled = false;
    if (uFile.value == "" || uDNI.value == "" || uName.value == "" || uLastname.value == "" || uArea.value == "" || 
        uEmail.value == "" || uNumber.value == "" || uPass.value == "" || rePass.value == "" ||
        isNaN(uFile.value) || uFile.value < 1 || uFile.value > 99999999 ||
        isNaN(uDNI.value) || uDNI.value < 999999 ||
        isNaN(uArea.value) || uArea.value < 1 ||
        CheckPass(uPass.value) ||
        uPass.value != rePass.value) {
        button.classList.add("form-button-disabled");
        return false;
    }
    else {
        button.classList.remove("form-button-disabled");
        return true;
    }
}

function UsersFormButton(e) {
    if (!CheckUsersFormButton())
        e.preventDefault();
}

function RestoreUsersForm() {
    var uFile = document.getElementById("uFile"), uDNI = document.getElementById("uDNI"),
        uName = document.getElementById("uName"), uLastname = document.getElementById("uLastname"),
        uArea = document.getElementById("uArea"),
        uEmail = document.getElementById("uEmail"), uNumber = document.getElementById("uNumber"),
        errorLabel = document.getElementById("form_error_label");
    
    uFile.classList.remove("form-input-error");
    uDNI.classList.remove("form-input-error");
    uName.classList.remove("form-input-error");
    uLastname.classList.remove("form-input-error");
    uArea.classList.remove("form-input-error");
    uEmail.classList.remove("form-input-error");
    uNumber.classList.remove("form-input-error");

    errorLabel.innerHTML = "&nbsp";
    CheckUsersPass();
}






function CheckAreasForm() {
    var aName = document.getElementById("aName"), aNumber = document.getElementById("aNumber"),
        nPass = document.getElementById("nPass"), rePass = document.getElementById("rePass"),
        errorLabel = document.getElementById("form_error_label"),
        error = "&nbsp";

    if (aName.value == "") {
        aName.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (aNumber.value == "") {
        aNumber.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (nPass.value == "") {
        nPass.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (rePass.value == "") {
        rePass.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (error == "&nbsp") {
        if (errorStr = CheckPass(nPass.value)) {
            nPass.classList.add("form-input-error");
            error = errorStr;
        }
        else if (nPass.value != rePass.value) {
            rePass.classList.add("form-input-error");
            error = "Las contraseñas no coinciden";
        }
    }

    CheckAreasFormButton();
    errorLabel.innerHTML = error;
}

function CheckAreasPass() {
    var nPass = document.getElementById("nPass"),
        errorLabel = document.getElementById("form_error_label");

    error = "&nbsp";
    if (nPass.value == "" || !(errorStr = CheckPass(nPass.value))) 
        nPass.classList.remove("form-input-error");
    else {
        nPass.classList.add("form-input-error");
        error = errorStr;
    }

    if (error == "&nbsp")
        CheckAreasRePass();
    else {
        CheckAreasFormButton();
        errorLabel.innerHTML = error;
    }
}

function CheckAreasRePass() {
    var nPass = document.getElementById("nPass"), rePass = document.getElementById("rePass"),
        errorLabel = document.getElementById("form_error_label"),
        error = "&nbsp";

    if (nPass.value == rePass.value)
        rePass.classList.remove("form-input-error");
    else {
        rePass.classList.add("form-input-error");
        error = "Las contraseñas no coinciden";
    }

    CheckAreasFormButton();
    errorLabel.innerHTML = error;
}

function CheckAreasFormButton() {
    var aName = document.getElementById("aName"), aNumber = document.getElementById("aNumber"),
        nPass = document.getElementById("nPass"), rePass = document.getElementById("rePass"),
        button = document.getElementById("submit");
    
    button.disabled = false;
    if (aName.value == "" || aNumber.value == "" || nPass.value == "" || rePass.value == "" ||
        CheckPass(nPass.value) ||
        nPass.value != rePass.value) {
        button.classList.add("form-button-disabled");
        return false;
    }
    else {
        button.classList.remove("form-button-disabled");
        return true;
    }
}

function AreasFormButton(e) {
    if (!CheckAreasFormButton())
        e.preventDefault();
}

function RestoreAreasForm() {
    var aName = document.getElementById("aName"), aNumber = document.getElementById("aNumber"),
        nPass = document.getElementById("nPass"), rePass = document.getElementById("rePass"),
        errorLabel = document.getElementById("form_error_label");
    
    aName.classList.remove("form-input-error");
    aNumber.classList.remove("form-input-error");
    nPass.classList.remove("form-input-error");
    rePass.classList.remove("form-input-error");

    errorLabel.innerHTML = "&nbsp";
    CheckAreasPass();
}






function CheckSheetsForm() {
    var hDNI = document.getElementById("hDNI"), hName = document.getElementById("hName"),
        hLastname = document.getElementById("hLastname"), hData = document.getElementById("hData"),
        errorLabel = document.getElementById("form_error_label"),
        error = "&nbsp";

    if (hDNI.value == "") {
        hDNI.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (hName.value == "") {
        hName.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (hLastname.value == "") {
        hLastname.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (hData.value == "") {
        hData.classList.add("form-input-error");
        error = "Campos incompletos";
    }
    if (error == "&nbsp") {
        if (isNaN(hDNI.value) || hDNI.value < 999999) {
            hDNI.classList.add("form-input-error");
            error = "Número de documento inválido";
        }
    }

    CheckSheetsFormButton();
    errorLabel.innerHTML = error;
}

function CheckSheetsFormButton() {
    var hDNI = document.getElementById("hDNI"), hName = document.getElementById("hName"),
        hLastname = document.getElementById("hLastname"), hData = document.getElementById("hData"),
        button = document.getElementById("submit");
    
    button.disabled = false;
    if (hDNI.value == "" || hName.value == "" || hLastname.value == "" || hData.value == "" ||
        isNaN(hDNI.value) || hDNI.value < 999999) {
        button.classList.add("form-button-disabled");
        return false;
    }
    else {
        button.classList.remove("form-button-disabled");
        return true;
    }
}

function SheetsFormButton(e) {
    if (!CheckSheetsFormButton())
        e.preventDefault();
}

function RestoreSheetsForm() {
    var hDNI = document.getElementById("hDNI"), hName = document.getElementById("hName"),
        hLastname = document.getElementById("hLastname"), hData = document.getElementById("hData"),
        errorLabel = document.getElementById("form_error_label");
    
    hDNI.classList.remove("form-input-error");
    hName.classList.remove("form-input-error");
    hLastname.classList.remove("form-input-error");
    hData.classList.remove("form-input-error");

    errorLabel.innerHTML = "&nbsp";
    CheckSheetsFormButton();
}

