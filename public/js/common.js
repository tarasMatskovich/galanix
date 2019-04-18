function resetRegErrors(inputs) {
    for (var i = 0; i < inputs.length - 2; i++) {
        inputs[i].className = "form-control";
    }
}

function displayRegValidFields(errors, inputs) {
    for (var i = 0; i < inputs.length - 2; i++) {
        if (errors.indexOf(inputs[i].id) === -1) {
            inputs[i].className = inputs[i].className + ' is-valid';
        } else {
            inputs[i].className = inputs[i].className + ' is-invalid';
        }
    }
}

function resetLogErrors(inputs) {
    for (var i = 0; i < inputs.length - 1; i++) {
        inputs[i].className = "form-control";
    }
}

function displayLogValidFields(errors, inputs) {
    for (var i = 0; i < inputs.length - 1; i++) {
        if (errors.indexOf(inputs[i].id) === -1) {
            inputs[i].className = inputs[i].className + ' is-valid';
        } else {
            inputs[i].className = inputs[i].className + ' is-invalid';
        }
    }
}
reg = document.getElementById('reg');
if (reg) {
    reg.onclick = (e) => {
        var elems = reg.form.elements;
        resetRegErrors(elems);
        var errors = [];
        if (!elems.email.value) {
            errors.push(elems.email.id);
        }
        if (!elems.name.value) {
            errors.push(elems.name.id);
        }
        if (!elems.surname.value) {
            errors.push(elems.surname.id);
        }
        if (!elems.phone.value) {
            errors.push(elems.phone.id);
        }
        if (!elems.password.value) {
            errors.push(elems.password.id);
        }
        if (elems.password.value !== elems.password_confirm.value) {
            errors.push(elems.password_confirm.id);
        }
        displayRegValidFields(errors, elems);
        if (errors.length === 0) {
            return true;
        } else {
            return false;
        }
    }
}

log = document.getElementById('log');
if (log) {
    log.onclick = (e) => {
        var elems = log.form.elements;
        resetLogErrors(elems);
        var errors = [];
        if (!elems.email.value) {
            errors.push(elems.email.id);
        }
        if (!elems.password.value) {
            errors.push(elems.password.id);
        }
        displayLogValidFields(errors, elems);
        if (errors.length === 0) {
            return true;
        } else {
            return false;
        }
    }
}