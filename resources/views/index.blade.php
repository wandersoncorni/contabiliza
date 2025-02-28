<x-layout>
<div class="tab-content" id="appTabContent">
  <div class="tab-pane fade show active" id="analises" role="tabpanel" aria-labelledby="analises-tab">@include('analises')</div>
  <div class="tab-pane fade" id="analise" role="tabpanel" aria-labelledby="analaise-tab">@include('analise')</div>
  <div class="tab-pane fade" id="config" role="tabpanel" aria-labelledby="config-tab">@include('config')</div>
  <div class="tab-pane fade" id="extrator" role="tabpanel" aria-labelledby="extrator-tab">@include('extrator')</div>
</div>
</x-layout>