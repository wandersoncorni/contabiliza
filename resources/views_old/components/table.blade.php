<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = 'table table-striped' . (isset($attrs['class']) ? $attrs['class'] : '');
$attributes->setAttributes($attrs);
?>
<div class="table-responsive">
    <table {{$attributes}}>
        <thead>
            <tr>
                @stack('th'.$id)
            </tr>
        </thead>
        <tbody>
            @stack('tbody'.$id)
        </tbody>
    </table>
</div>
