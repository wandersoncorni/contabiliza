<?php
$partial = null;
/*
 * O contexto eh identificado pelo perfil que estah associado a session no momento.
 * Os perfis que terao um painel serao admin, gerente, cliente
 */
$partial = current(Auth::user()->person->roles);
if(!is_null(session('contexto'))){
    $partial = session('contexto');
}
?>
@include('application::partials.painel_' . $partial);