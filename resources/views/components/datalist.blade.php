<?php
/**
 * Componente para geracao de datalist BS5
 * A lista ($list) eh atribuida na chamada ao componente. Deverah ser um array onde a chave ($item) serah
 * o texto a ser buscado, que serah o valor da tag option. O valor referente a essa chave no array deverah
 * ser passado como um id ou vazio.
 * Uso:<x-datalist id="teste" label="Teste" :list="['teste'=>'']"></x-datalist>
 */
 $attrs = $attributes->getAttributes();
 $placeholder = $placeholder ?? "Digite para buscar...";
?>
<label for="{{$id}}DataList" class="form-label">{{$label}}</label>
<input class="form-control" list="{{$id}}datalistOptions" id="{{$id}}DataList" placeholder="{{$placeholder}}">
<datalist id="{{$id}}datalistOptions">
    @foreach($list as $iten=>$id)
    <option value="{{$iten}}" @if(strlen($id)) id="{{$id}}" @endif></option>
    @endforeach
</datalist>
