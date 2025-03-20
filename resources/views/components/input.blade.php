<?php
$attrs = $attributes->getAttributes();
$attrs['type'] = $attrs['type'] ?? 'text';
if($attrs['type'] != 'hidden'){
$attrs['class'] = 'form-control' . (isset($attrs['class']) ? $attrs['class'] : '');
}
$attributes->setAttributes($attrs);
?>
@if($title ?? false)
<label for="{{$id ?? ''}}" class="form-label">{{$title ?? ''}}</label>
@endif
<input {{$attributes}} />
