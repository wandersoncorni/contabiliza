<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = 'alert' . (isset($attrs['class']) ? ' '.$attrs['class'] : '');
$attributes->setAttributes($attrs);
?>

<div {{$attributes}} role="alert">
    {{$slot}}
</div>
