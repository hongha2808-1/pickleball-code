<?php

// Get all products or filter by search query
function list_products($search = '') {
    if(empty($search)) {
        $result = db_fetch_array("SELECT p.*, c.cat_title 
                                FROM `list_products` p 
                                LEFT JOIN `list_products_cat` c ON p.cat_id = c.id
                                ORDER BY p.id DESC");
    } else {
        $result = db_fetch_array("SELECT p.*, c.cat_title 
                                FROM `list_products` p 
                                LEFT JOIN `list_products_cat` c ON p.cat_id = c.id
                                WHERE p.product_title LIKE '%{$search}%'
                                ORDER BY p.id DESC");
    }
    return $result;
}

// Get product categories
function get_categories() {
    return db_fetch_array("SELECT * FROM `list_products_cat` ORDER BY cat_title ASC");
}

// Get single product by ID
function get_product_by_id($id) {
    return db_fetch_row("SELECT * FROM `list_products` WHERE id = {$id}");
}

// Add new product
function add_product($data) {
    return db_insert('list_products', $data);
}

// Update product
function update_product($id, $data) {
    return db_update('list_products', $data, "id = {$id}");
}

// Delete product
function delete_product($id) {
    return db_delete('list_products', "id = {$id}");
}

// Toggle featured status
function toggle_featured($id, $status) {
    return db_update('list_products', ['is_featured' => $status], "id = {$id}");
}

// Count total products
function count_products() {
    return db_num_rows("SELECT id FROM `list_products`");
}

// Count products by category
function count_products_by_cat($cat_id) {
    return db_num_rows("SELECT id FROM `list_products` WHERE cat_id = {$cat_id}");
}

// SLIDER FUNCTIONS

// Get all sliders
function get_sliders($search = '') {
    if(empty($search)) {
        return db_fetch_array("SELECT * FROM `tbl_sliders` ORDER BY num_order ASC, id DESC");
    } else {
        return db_fetch_array("SELECT * FROM `tbl_sliders` WHERE title LIKE '%{$search}%' ORDER BY num_order ASC, id DESC");
    }
}

// Get slider by ID
function get_slider_by_id($id) {
    return db_fetch_row("SELECT * FROM `tbl_sliders` WHERE id = {$id}");
}

// Add new slider
function add_slider($data) {
    return db_insert('tbl_sliders', $data);
}

// Update slider
function update_slider($id, $data) {
    return db_update('tbl_sliders', $data, "id = {$id}");
}

// Delete slider
function delete_slider($id) {
    return db_delete('tbl_sliders', "id = {$id}");
}

// Count total sliders
function count_sliders() {
    return db_num_rows("SELECT id FROM `tbl_sliders`");
}

// Count sliders by status
function count_sliders_by_status($status) {
    return db_num_rows("SELECT id FROM `tbl_sliders` WHERE status = {$status}");
}

// Get active sliders for frontend
function get_active_sliders() {
    return db_fetch_array("SELECT * FROM `tbl_sliders` WHERE status = 1 ORDER BY num_order ASC, id DESC");
}

