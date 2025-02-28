<?php
/**
 * Exibe alertas do servidor
 * Uso:
 *  chave: 'message';
 *  array: ['type'=>'','text':'']
 * ... ->with('message', ['type' => 'danger', 'text' => 'Ocorreu um erro ao executar o cadastro!'])
 */
?>
@if (session('message'))
<div class="alert alert-{{ session('message')['type'] }}">
    {{ session('message')['text'] }}
</div>
@endif
