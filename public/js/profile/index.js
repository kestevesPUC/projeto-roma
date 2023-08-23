const Profile = function () {
    const updateImage = function () {
        document.getElementById('get_file').onclick = function() {
            document.getElementById('image').click();

            $('#save-info-profile').on('click', function () {
                const  imagemInput = $("#image")[0]
                const file = imagemInput.files[0];

                const formData = new FormData();
                formData.append('imagem', file);
                formData.append('id', $("#id").val());
                formData.append('_token', $("meta[name='csrf-token']").attr('content'));

                if (file) {
                    $.ajax({
                        url: route('profile.update-image'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response)
                        },
                        error: function (erro) {
                            console.log("erro:", erro)
                        }
                    }); // Ajax
                }
            });
        };
    }

    const updateDescription = function () {
        $('#btn_info-additional').on('click', function () {
            $.ajax({
               url: route('profile.update-descricao'),
               type: 'POST',
               data: {
                   'value':  $('#descricao_id').val(),
                    'id': $('#descricao_id').data('description'),
                    'user': $('#descricao_id').data('user'),
                    '_token': $("meta[name='csrf-token']").attr('content')
               },
                success: function (response) {
                    console.log(response)
                },
                error: function (error) {
                    console.log(erro)
                }
            }); // Ajax
        })
    }

    const updateStatus = function () {
        $("#btn-status").on('click', function () {
            let status = $('#status').is(':checked');

            if (status != $('#status').val()) {
                $.ajax({
                    url: route('profile.update-status'),
                    type: 'POST',
                    data: {
                        'status':  status,
                        'user': $('#id').val(),
                        '_token': $("meta[name='csrf-token']").attr('content')
                    },
                    success: function (response) {
                        console.log(response)
                    },
                    error: function (error) {
                        console.log(erro)
                    }
                }); // Ajax
            }
        });
    }
    return {
        init: function () {
            updateImage();
            updateDescription();
            updateStatus();
        }
    }
}();
