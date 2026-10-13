<?php
$content = file_get_contents('extracted_prompt.txt');
$content = preg_replace('/<truncated.*?>/', '', $content);
file_put_contents('cleaned_prompt.txt', $content);
echo "Cleaned!";
