import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

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
            .then(async (userCredential) => {
                console.log("Firebase OK");
                const emailUser = userCredential.user.email;
                console.log("Email:", emailUser);

                
                const resposta = await fetch(`/TCC/controller/verifica-permissao.php?email=${emailUser}`);
                console.log("Status:", resposta.status);
                
                const dados = await resposta.json();
                console.log(dados);

                
                if (dados.funcao === "Gerente") {
                    alert("Bem-vindo gerente");
                    window.location.href = "/TCC/view/menu.php";
                } else if (dados.funcao === "Funcionario") {
                    alert("Bem-vindo funcionário");
                    window.location.href = "/TCC/view/funcionario.php";
                } else {
                    alert("Permissão não encontrada");
                }
            }) 
            .catch((error) => {
                alert("Erro ao logar: " + error.message);
            });
    });
}