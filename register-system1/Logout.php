<?php

session_start();
session_destroy();

header('location:index.php');

?>
<script type="text/javascript">
    window.history.forward();
</script>

