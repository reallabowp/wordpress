<?php
$key = "url";
$redirect = get_post_meta($post->ID, $key, true);
header("Location:$redirect");

exit;
?>
