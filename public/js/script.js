function login(){

    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    if(email === '' || senha === ''){
        alert('Preencha todos os campos');
        return;
    }

    document.getElementById('loading').style.display = 'block';

    setTimeout(()=>{

        if(email === 'admin@ipil.com'){
            window.location.href = 'admin.html';
        }else{
            window.location.href = 'index.html';
        }

    },3000);
}

function cadastro(){

    alert('Conta criada com sucesso!');
    window.location.href='login.html';
}

function recuperarSenha(){

    alert('Link de recuperação enviado para o email!');
}

function enviarFeedback(){

    const feedback = document.getElementById('feedback').value;

    if(feedback === ''){
        alert('Digite o feedback');
        return;
    }

    alert('Feedback enviado com sucesso!');

    document.getElementById('feedback').value='';
}