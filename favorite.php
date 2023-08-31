<?php
session_start();

if (!isset($_SESSION['favorites']))
{
    $_SESSION['favorites'] = [];
}

function is_ajax_request()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

function array_remove($element = 0, $array = [])
{
    $length = 1;
    $offset = array_search($element, $array);
    array_splice($array, $offset, $length);
    return $array;
}

if (!is_ajax_request())
{
    exit;
}

//extract id
$raw_id = isset($_POST['id']) ? $_POST['id'] : 'nothing';
//echo $raw_id;
$pattern = '/blog-post-(\d+)/';
if (preg_match($pattern, $raw_id, $matches))
{
    $id = $matches[1];

    if (!in_array($id, $_SESSION['favorites']))
    {
        $_SESSION['favorites'][] = $id;
        echo 'added';
        return;
    }
    else
    {
        $_SESSION['favorites'] = array_remove($id, $_SESSION['favorites']);
        echo 'removed';
        return;
    }
}
else
{
    echo 'false';
}
//store in a session_abort()
//return true or false