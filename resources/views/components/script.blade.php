<?php
$scriptText = file_get_contents($path);
?>
<script type='text/javascript'>
    @php print $scriptText @endphp

</script>
