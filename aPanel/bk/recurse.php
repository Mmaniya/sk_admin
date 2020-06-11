<?php
//Let's assume you have your data from the database as such
$arr = array(
    array('id' => 1, 'parent' => 0),
    array('id' => 2, 'parent' => 0),
    array('id' => 3, 'parent' => 0),
    array('id' => 4, 'parent' => 1),
    array('id' => 5, 'parent' => 4),
    array('id' => 6, 'parent' => 5));

function get_key($arr, $id)
{
    foreach ($arr as $key => $val) {
        if ($val['id'] === $id) {
            return $key;
        }
    }
    return null;
}

function get_parent($arr, $id)
{
    $key = get_key($arr, $id);
    if ($arr[$key]['parent'] == 0)
    {
        return $id;
    }
    else 
    {
        return get_parent($arr, $arr[$key]['parent']);
    }
}

echo get_parent($arr, 6);
?>