const Register = function () {
    const cadastro = function () {
        $("#registrar").on('click', function() {
           let nome = $("#name").val();
           let cpf = $("#cpf").val();
           let matricula = $("#matricula").val();
           let password = $("#password").val();
           let password_confirmation = $("#password_confirmation").val();

           if(password == password_confirmation) {
               $.ajax({
                   url: route('registerUser'),
                   type: 'POST',
                   data: {
                       name: nome,
                       cpf: cpf,
                       matricula: matricula,
                       senha: password,
                       _token: $("meta[name='csrf-token']").attr('content')
                   },
                   success: function (response) {
                       message(response)
                   }
               }); //ajax

           } else {
               //senhas divergentes
               Swal.fire({
                   title: 'Falha',
                   text: "Senhas divergentes!",
                   icon: 'error',
               });
           }
        });
    }

    const message = function (data) {
        if (data.success == false) {
            Swal.fire({
                title: 'Falha',
                text: data.message,
                icon: 'error'
            });
        } else {
            Swal.fire({
                title: 'Sucesso!',
                text: data.message,
                icon: 'success',
                timer: 5000
            })
            window.location.href = route('edit-usuarios',[data.id]);
        }
    }
    return {
        init: function () {
            cadastro();
        }
    }
}();
