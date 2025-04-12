<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = "card" . (isset($attrs['class']) ? ' '.$attrs['class'] : '');
$attributes->setAttributes($attrs);
?>

<div {{$attributes}}>
    @if(isset($title))
    <div class="card-header">
        <h5 class="card-title">{{$title}}</h5>
    </div>
    @endif
    <div class="card-body">
        {{$slot}}
    </div>
</div>
