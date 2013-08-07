<?php

function thumb($src = '')
{
    return str_replace(
        array('.jpg','.png','.gif'),
        array('_thumb.jpg','_thumb.png','_thumb.gif'),
        $src
    );
}