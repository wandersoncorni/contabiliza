<?php
$attrs = $attributes->getAttributes();
$attrs['class'] = isset($attrs['class']) ? 'modal '.$attrs['class']: 'modal';
$size = ' '.($attrs['size']??'');
$name = $attrs['data-name']??'';
unset($attrs['size'],$attrs['name']);
$attributes->setAttributes($attrs);
?>

<div {{$attributes}} data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="{{$id ?? ''}}Label" aria-hidden="true">
    <div class="modal-dialog{{$size}}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title ?? ''}}</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
            <div class="modal-footer">
                @stack('modal_btn'.$name)
            </div>
        </div>
    </div>
</div>
