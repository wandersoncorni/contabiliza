<ul class="nav nav-tabs" id="{{ $id }}" role="tablist">
    @foreach($abas as $index=>$label)
    <li class="nav-item" role="presentation">
        <button class="nav-link @if($index == 0)active @endif" id="tab-{{ $index }}" data-coreui-toggle="tab" data-coreui-target="#pane-{{ $index }}" type="button" role="tab" aria-controls="pane-{{ $index }}" aria-selected="true">{{$label}}</button>
    </li>
    @endforeach
</ul>
<div class="tab-content">
    @foreach(explode('@',$slot) as $index=>$content)
    <div class="tab-pane p-4 @if($index == 0)active @endif" id="pane-{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}" tabindex="0">
        @php print($content) @endphp
    </div>
    @endforeach
</div>
