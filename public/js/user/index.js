const User = function () {
    const grupoUsuario = function () {
        let value;
            if($('#grupo_usuario1').is(':checked')) {
                value = $('#grupo_usuario1').val();
            } else if($('#grupo_usuario2').is(':checked')) {
                value = $('#grupo_usuario2').val();
            } else {
                value = $('#grupo_usuario3').val();
            }


        return value;
    }

    const ajax = function () {
        $('#save_user_group').on('click', function() {
            let tipo = grupoUsuario();
            $.ajax({
               url: route('profile.edit'),
               type: 'get' ,
                data:  tipo,
                success: function (response) {
                    alert(response)
                    console.log('awui')
                },
                error: function (error) {
                    alert('error')
                    console.log('ali')
                }
            }); // ajax
        });
    }
    return {
        init: function () {
            ajax();
        }
    }
}();
