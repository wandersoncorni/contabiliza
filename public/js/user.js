/**
 * Scritps para o form usuario 
 */
$(function () {
    $.getJSON('/profile/listar', function (res) {
        $('[name=id]').val(res.id);
        $('[name=nome_social]').val(res.atributos.nome_social);
        $('[id=nome_usuario]').val(res.nome_usuario);
        $('[name=email]').val(res.email);
        $('[name=idioma]').val(res.atributos.idioma);
        $('#termo > p').html((res.termo).replace('{{anexos}}', ''));
        $('#termo > ul').append(
            function () {
                const lista = [];
                res['anexos'].map((val) => {
                    lista.push(
                        $('<li />').append(
                            $('<a />', { href: `/arquivos/${val.id_arquivo}.pdf`, target: '_blank' }).html(val.nome)
                        )
                    );
                });
                return lista;
            }
        )
    });
});