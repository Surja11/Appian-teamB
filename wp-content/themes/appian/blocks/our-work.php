<?php
$content = get_field('Work') ?: 'Our Work';
echo '<pre>';
print_r($content);
echo '</pre>';
?>