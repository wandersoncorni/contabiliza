<?php
$attrs = $attributes->getAttributes();
$size = $attrs['size']??'';
$id = $attrs['id'];
$title = $attrs['title'];
unset($attrs['id'],$attrs['title'],$attrs['size']);
$attributes->setAttributes($attrs);
?>

<div id="{{$id}}" class="modal fade" tabindex="-1" aria-labelledby="{{$id}}Label" aria-hidden="true" {{$attributes}}>
    <div class="modal-dialog {{$size}}">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title" id="{{$id}}Label">{{$title}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$slot}}
            </div>
            <div class="modal-footer">
                @stack("modal-footer-$id")
            </div>
        </div>
    </div>
</div>
