// Função para garantir que apenas um cargo seja selecionado
function selecionarCargo(selecionado) {
    document.querySelectorAll('input[name="cargo"]').forEach(cb => {
        if (cb !== selecionado) cb.checked = false;
    });

    const opcoesFuncionario = document.getElementById('opcoesFuncionario');
    if (selecionado.value === 'Funcionario' && selecionado.checked) {
        opcoesFuncionario.style.display = 'block';
    } else {
        opcoesFuncionario.style.display = 'block'; // agora também exibe setor para Gerente
        // Desmarca todas as opções de setor se não for selecionado nenhum cargo
        document.querySelectorAll('input[name="setor"]').forEach(cb => cb.checked = false);
    }
}

// Função para garantir que apenas um setor seja selecionado
function selecionarSetor(selecionado) {
    document.querySelectorAll('input[name="setor"]').forEach(cb => {
        if (cb !== selecionado) cb.checked = false;
    });
}

// Validação de formulário
function validarFormulario() {
    const cargoSelecionado = document.querySelectorAll("input[name='cargo']:checked");
    const senha = document.getElementById("senha").value;
    const confirmar = document.getElementById("confirmarSenha").value;

    if (cargoSelecionado.length === 0) {
        alert("Selecione um cargo!");
        return false;
    }

    // Exigir setor para todos os cargos
    const setorSelecionado = document.querySelectorAll("input[name='setor']:checked");
    if (setorSelecionado.length === 0) {
        alert("Selecione um setor!");
        return false;
    }

    if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        return false;
    }
    return true;
}

// Garantir exibição do setor ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
    const cargoInputs = document.querySelectorAll("input[name='cargo']");
    const setorDiv = document.getElementById("opcoesFuncionario");
    const setorInputs = document.querySelectorAll("input[name='setor']");

    cargoInputs.forEach((input) => {
        input.addEventListener("change", () => {
            if (input.checked) {
                setorDiv.style.display = 'block';
            } else {
                setorDiv.style.display = 'none';
                setorInputs.forEach((setor) => setor.checked = false);
            }
        });
    });
});