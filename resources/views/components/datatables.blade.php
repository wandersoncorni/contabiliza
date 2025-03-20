<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = "table table-striped" . (isset($attrs['class']) ? ' '.$attrs['class']: '');
$attributes->setAttributes($attrs);
?>
<div class="table-responsive">
    <table {{$attributes}}>
        <thead>
            <tr>
                {{ $slot }}
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
