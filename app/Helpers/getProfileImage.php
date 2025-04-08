<?php


function getProfileImage($userId) {
    $db = \Config\Database::connect();
    $query = $db->table('admin')->select('picture')->where('id', $userId)->get()->getRow();
    return $query ? base_url('public/dist/img/uploads/' . $query->picture) : base_url('uploads/default.png');
}
?>