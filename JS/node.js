function validarFormulario() {
    let senha = document.getElementById("senha").value;
    let confirmar = document.getElementById("confirmar_senha").value;

    if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        return false;
    }

    let checkboxes = document.querySelectorAll("input[name='cargo']:checked");
    if (checkboxes.length === 0) {
        alert("Selecione pelo menos um cargo!");
        return false;
    } else if (checkboxes.length > 1) {
        alert("Selecione apenas um cargo!");
        return false;
    }

    return true;
}