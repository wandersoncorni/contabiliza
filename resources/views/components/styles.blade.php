<?php
$scriptText = file_get_contents(resource_path() . "/css/" . "$file.css");
?>
@push('style')
<style>
    @php print $scriptText @endphp

</style>
@endpush
