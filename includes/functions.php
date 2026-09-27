<?php
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect($url) { header('Location: ' . $url); exit; }
function statusClass($status) {
    return strtolower(preg_replace('/[^a-z]/i', '', $status));
}
?>
