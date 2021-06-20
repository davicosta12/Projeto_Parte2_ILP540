"use strict"

const inputName = document.getElementById('nome');
const inputEmail = document.getElementById('email');
const inputTelefone = document.getElementById('telefone');
const textarea = document.getElementById('msg');
const confirmBtn = document.getElementById('btnConfirm');
const btnLimpar = document.getElementById('btnLimpar');

inputName.focus();

inputTelefone.addEventListener("keyup", () => {
    if (isNaN(inputTelefone.value)) {
        inputTelefone.style.border = "solid 2px red";
    }
    else {
        inputTelefone.style.border = "2px solid rgb(66, 137, 165)";
    }
});

inputTelefone.addEventListener("blur", () => {
    inputTelefone.style.border = "1px solid #999";
});

inputTelefone.addEventListener("focus", () => {
    if (isNaN(inputTelefone.value)) {
        inputTelefone.style.border = "solid 2px red";
    }
    else {
        inputTelefone.style.border = "2px solid rgb(66, 137, 165)";
    }
});

confirmBtn.addEventListener("click", event => {
    let erros = [];
    
    if (!validateNome(inputName.value))
    erros.push("O nome deve conter ao menos três letras, e não pode conter números");
    
    if (!validateEmail(inputEmail.value))
    erros.push("Digite um email válido");
    
    if (!validateTelefone(inputTelefone.value))
    erros.push("O telefone deve ter ao menos 9 números");

    if (!validateMsg(textarea.value))
        erros.push("A mensagem deve ter ao menos 5 caracteres");

    alerta(erros, event);

});

btnLimpar.addEventListener("click", event => {
    inputName.value = "";
    inputEmail.value = "";
    inputTelefone.value = "";
    textarea.value = "";
    event.preventDefault();
});

function validateEmail(email) {
    const reg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return reg.test(String(email).toLowerCase());
}

function validateMsg(msg) {
    if(!msg || msg.length<5)
        return false;
    return true;
}
function validateNome(nome) {
    const reg = /[0-9]/;
    if(!nome || nome.length<3 || reg.test(nome))
        return false;
    return true;
}
function validateTelefone(telefone) {
    if (!telefone || isNaN(telefone) || telefone.length < 9)
        return false
    return true
}

function alerta(erros, event) {
    if (erros.length > 0){
        alert(erros.join("\n"));
        event.preventDefault();
    }
}
