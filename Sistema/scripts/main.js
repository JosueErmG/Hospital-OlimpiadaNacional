function FillDataTable() {
    
}

function IntOrSubmit(e, oText) {
    if (e.keyCode == 13) {
        oText.form.submit();
        e.preventDefault();
    }
    else if (isNaN(e.key))
        e.preventDefault();
}

function ChangeInpVal(e, oImp, value, min = -1, max = -1) {
    oImp = document.getElementById(oImp);

    if (!Number.isInteger(value)) {
        if (value.substring(0, 1) == "+")
            value = oImp.value + value.substring(1);
        else if (value.substring(0, 1) == "-")
            value = oImp.value - value.substring(1);
    }

    if (min != -1)
        value = Math.max(min, value);
    if (max != -1)
        value = Math.min(value, max);

    if (oImp.value != value) {
        oImp.value = value;
        return;
    }
    e.preventDefault();
}



