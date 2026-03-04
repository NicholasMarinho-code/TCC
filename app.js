import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
import {
    getAuth,
    createUserWithEmailAndPassword,
    signInWithEmailAndPassword
} from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyB-HiFrcThUnE_yrfRx75qUsL8yx9VeOtY",
    authDomain: "tela-login-372a2.firebaseapp.com",
    projectId: "tela-login-372a2",
    storageBucket: "tela-login-372a2.firebasestorage.app",
    messagingSenderId: "191780137198",
    appId: "1:191780137198:web:31f207fe8a5bf3b2846bff"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);


const btnCadastro = document.getElementById("btCadastrar");

if (btnCadastro) {
    btnCadastro.addEventListener("click", () => {
        const email = document.getElementById("emailCadastro").value;
        const senha = document.getElementById("senhaCadastro").value;

        createUserWithEmailAndPassword(auth, email, senha)
            .then((userCredential) => {
                alert("Usuário criado com sucesso!");
                location.href = "login.php";
            })
            .catch((error) => {
                alert("Erro ao cadastrar: " + error.message);
            });
    });
}


const btnLogin = document.getElementById("btnLogin");

if (btnLogin) {
    btnLogin.addEventListener("click", () => {
        const email = document.getElementById("emailLogin").value;
        const senha = document.getElementById("senhaLogin").value;

        signInWithEmailAndPassword(auth, email, senha)
            .then((userCredential) => {
                alert("Logado com sucesso!");
                location.href = "../view/Usuarios.php";
            })
            .catch((error) => {
                alert("Erro ao logar: " + error.message);
            });
    });
}