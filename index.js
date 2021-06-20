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
    console.log()
    if (!inputName.value || !inputEmail.value ||
        !inputTelefone.value || !textarea.value) {
        alert("Não deixe nenhum campo vazio!");
        event.preventDefault();
    }

    if (isNaN(inputTelefone.value)) {
        alert("Digite somente números no campo telefone!");
        event.preventDefault();
    }

});

btnLimpar.addEventListener("click", event => {
    inputName.value = "";
    inputEmail.value = "";
    inputTelefone.value = "";
    textarea.value = "";
    event.preventDefault();
});
