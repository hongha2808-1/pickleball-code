<?php
function update_user_login($username, $data)
{
    db_update('tbl_users', $data, "`username` = '{$username}'");
}

function get_user_by_username($username)
{
    $item = db_fetch_row("SELECT * FROM `tbl_users` WHERE `username` = '{$username}'");
    if (!empty($item))
        return $item;
}

function check_login($username, $password)
{
    $check_user = db_num_rows("SELECT * FROM `tbl_users` WHERE `username` = '{$username}' AND `password` = '{$password}'");
    echo $check_user;
    if ($check_user > 0)
        return true;
    return false;
}

function add_user($data)
{
    return db_insert('tbl_users', $data);
}

function user_exists($username, $email)
{
    $check_user = db_num_rows("SELECT * FROM `tbl_users` WHERE `email` = '{$email}' OR `username` = '{$username}'");
    echo $check_user;
    if ($check_user > 0) {
        return true;
    }
    return false;
}

function get_list_users()
{
    $result = db_fetch_array("SELECT * FROM `tbl_users`");
    return $result;
}

function get_user_by_id($id)
{
    $item  = db_fetch_row("SELECT * FROM `tbl_users` WHERE `id` = {$id}");
    return $item;
}

function active_user($active_token)
{
    return db_update('tbl_users', array('is_active' => 1), "`active_token` = '{$active_token}'");
}

function check_active_token($active_token)
{
    $check = db_num_rows("SELECT * FROM `tbl_users` WHERE `active_token` = '{$active_token}' AND `is_active` = '0'");
    if ($check > 0) {
        return true;
    }
    return false;
}

function delete()
{
    $delete = db_query("DELETE FROM `tbl_users` WHERE `is_active` = 0 AND TIMESTAMPDIFF(SECOND, created_at, NOW()) > 30");
    return $delete;
}

function check_email($email)
{
    $check = db_num_rows("SELECT * FROM `tbl_users` WHERE `email` = '{$email}'");
    if ($check > 0)
        return true;
    return false;
}

function update_reset_token($data, $email)
{
    db_update('tbl_users', $data, "`email` = '{$email}'");
}

function check_reset_token($reset_token)
{
    $check = db_num_rows("SELECT * FROM `tbl_users` WHERE `reset_token` = '{$reset_token}'");
    if ($check > 0)
        return true;
    return false;
}

function update_pass($data, $reset_token)
{
    db_update('tbl_users', $data, "`reset_token` = '{$reset_token}'");
}
