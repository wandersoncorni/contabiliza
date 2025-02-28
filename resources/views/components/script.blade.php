<?php
$scriptText = file_get_contents(resource_path() . "/js/" . "$file.js");
?>
<script type='text/javascript'>
    @php print $scriptText @endphp

</script>
