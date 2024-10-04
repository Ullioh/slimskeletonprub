<?php
$base = __DIR__ . '/../app/';

$folders = [
    'config',
];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        include_once($filename);
    }
}


$folders = [
    'lib',
    'model',
    'route',
    'controller',
];

foreach($folders as $f)
{
    foreach (glob($base . "$f/*.php") as $k => $filename)
    {
        require $filename;
    }
}