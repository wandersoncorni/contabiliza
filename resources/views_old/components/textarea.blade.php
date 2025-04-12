<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = 'form-control' . (isset($attrs['class']) ? $attrs['class'] : '');
$attributes->setAttributes($attrs);
?>
@if($title ?? false)
<label for="{{$id ?? ''}}" class="form-label">{{$title ?? ''}}</label>
@endif
<textarea {{$attributes}}></textarea>
