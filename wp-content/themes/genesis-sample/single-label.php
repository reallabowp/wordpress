<?php

$redirect = esc_url($post->post_content);
header("Location:$redirect");

exit;
?>
