<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = isset($attrs['class']) ? 'btn '.$attrs['class'] : 'btn btn-primary';
$attrs['type'] = $attrs['type'] ?? 'button';
$attributes->setAttributes($attrs);
?>
<button {{$attributes}}>{{$slot}}</button>
