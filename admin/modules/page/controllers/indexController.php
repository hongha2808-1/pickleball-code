<?php

function construct()
{
    //    echo "DÙng chung, load đầu tiên";
    load_model('index');
}

function listPostAction()
{
    load_view('listPost');
}

function addPageAction()
{
    load_view('addPage');
}

function listPageAction()
{
    load_view('listPage');
}

function addPostAction()
{
    load_view('addPost');
}

function listCatAction()
{
    load_view('listCat');
}

function listProductAction()
{
    $search = isset($_GET['s']) ? $_GET['s'] : '';
    $data = [
        'products' => list_products($search),
        'total_products' => count_products()
    ];
    load_view('listProduct', $data);
}

function addProductAction()
{
    global $error;
    $error = [];
    $uploaded_image = '';
    
    if (isset($_POST['btn-submit'])) {
        // Validate data
        if (empty($_POST['product_title'])) {
            $error['product_title'] = "Không được để trống tên sản phẩm";
        }
        
        if (empty($_POST['price_new'])) {
            $error['price_new'] = "Không được để trống giá mới";
        } elseif (!is_numeric($_POST['price_new'])) {
            $error['price_new'] = "Giá phải là số";
        }
        
        if (!empty($_POST['price_old']) && !is_numeric($_POST['price_old'])) {
            $error['price_old'] = "Giá cũ phải là số";
        }
        
        if (empty($_POST['cat_id'])) {
            $error['cat_id'] = "Bạn cần chọn danh mục";
        }
        
        if (empty($_POST['product_desc'])) {
            $error['product_desc'] = "Không được để trống mô tả";
        }
        
        // Xử lý upload ảnh
        $product_thumb = '';
        if(isset($_FILES['product_thumb']) && $_FILES['product_thumb']['size'] > 0) {
            $upload_dir = 'public/uploads/';
            
            // Tạo thư mục nếu chưa tồn tại
            if(!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Kiểm tra định dạng file
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($_FILES['product_thumb']['name'], PATHINFO_EXTENSION));
            
            if(!in_array($file_ext, $allowed_exts)) {
                $error['product_thumb'] = "Định dạng file không được hỗ trợ. Chỉ cho phép JPG, JPEG, PNG và GIF.";
            } 
            // Kiểm tra kích thước file (giới hạn 5MB)
            elseif($_FILES['product_thumb']['size'] > 5 * 1024 * 1024) {
                $error['product_thumb'] = "Kích thước file vượt quá 5MB.";
            }
            else {
                // Tạo tên file duy nhất
                $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;
                
                // Upload file
                if(move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_path)) {
                    $product_thumb = $upload_path;
                    $uploaded_image = $upload_path;
                } else {
                    $error['product_thumb'] = "Có lỗi xảy ra khi tải ảnh lên.";
                }
            }
        }
        
        // If no errors, proceed with adding product
        if (empty($error)) {
            $data = [
                'product_title' => $_POST['product_title'],
                'price_new' => $_POST['price_new'],
                'price_old' => !empty($_POST['price_old']) ? $_POST['price_old'] : 0,
                'product_desc' => $_POST['product_desc'],
                'product_content' => $_POST['product_content'],
                'product_thumb' => $product_thumb,
                'cat_id' => $_POST['cat_id'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];
            
            add_product($data);
            redirect("?mod=page&action=listProduct");
        }
    }
    
    $data = [
        'categories' => get_categories(),
        'uploaded_image' => isset($uploaded_image) ? $uploaded_image : ''
    ];
    
    load_view('addProduct', $data);
}

function editProductAction()
{
    global $error;
    $error = [];
    $uploaded_image = '';
    
    $id = (int)$_GET['id'];
    if (!$id) {
        redirect("?mod=page&action=listProduct");
    }
    
    $product = get_product_by_id($id);
    if (!$product) {
        redirect("?mod=page&action=listProduct");
    }
    
    if (isset($_POST['btn-update'])) {
        // Validate data
        if (empty($_POST['product_title'])) {
            $error['product_title'] = "Không được để trống tên sản phẩm";
        }
        
        if (empty($_POST['price_new'])) {
            $error['price_new'] = "Không được để trống giá mới";
        } elseif (!is_numeric($_POST['price_new'])) {
            $error['price_new'] = "Giá phải là số";
        }
        
        if (!empty($_POST['price_old']) && !is_numeric($_POST['price_old'])) {
            $error['price_old'] = "Giá cũ phải là số";
        }
        
        if (empty($_POST['cat_id'])) {
            $error['cat_id'] = "Bạn cần chọn danh mục";
        }
        
        if (empty($_POST['product_desc'])) {
            $error['product_desc'] = "Không được để trống mô tả";
        }
        
        // Xử lý upload ảnh
        $product_thumb = isset($_POST['old_product_thumb']) ? $_POST['old_product_thumb'] : '';
        
        if(isset($_FILES['product_thumb']) && $_FILES['product_thumb']['size'] > 0) {
            $upload_dir = 'public/uploads/';
            
            // Tạo thư mục nếu chưa tồn tại
            if(!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Kiểm tra định dạng file
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($_FILES['product_thumb']['name'], PATHINFO_EXTENSION));
            
            if(!in_array($file_ext, $allowed_exts)) {
                $error['product_thumb'] = "Định dạng file không được hỗ trợ. Chỉ cho phép JPG, JPEG, PNG và GIF.";
            } 
            // Kiểm tra kích thước file (giới hạn 5MB)
            elseif($_FILES['product_thumb']['size'] > 5 * 1024 * 1024) {
                $error['product_thumb'] = "Kích thước file vượt quá 5MB.";
            }
            else {
                // Tạo tên file duy nhất
                $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;
                
                // Upload file
                if(move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_path)) {
                    $product_thumb = $upload_path;
                    $uploaded_image = $upload_path;
                } else {
                    $error['product_thumb'] = "Có lỗi xảy ra khi tải ảnh lên.";
                }
            }
        }
        
        // If no errors, proceed with updating product
        if (empty($error)) {
            $data = [
                'product_title' => $_POST['product_title'],
                'price_new' => $_POST['price_new'],
                'price_old' => !empty($_POST['price_old']) ? $_POST['price_old'] : 0,
                'product_desc' => $_POST['product_desc'],
                'product_content' => $_POST['product_content'],
                'product_thumb' => $product_thumb,
                'cat_id' => $_POST['cat_id'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];
            
            update_product($id, $data);
            redirect("?mod=page&action=listProduct");
        }
    }
    
    $data = [
        'product' => $product,
        'categories' => get_categories(),
        'uploaded_image' => isset($uploaded_image) ? $uploaded_image : ''
    ];
    
    load_view('editProduct', $data);
}

function deleteProductAction()
{
    $id = (int)$_GET['id'];
    if ($id) {
        delete_product($id);
    }
    
    redirect("?mod=page&action=listProduct");
}

function toggleFeaturedAction()
{
    $id = (int)$_GET['id'];
    $status = (int)$_GET['status'];
    
    if ($id) {
        toggle_featured($id, $status ? 0 : 1);
    }
    
    redirect("?mod=page&action=listProduct");
}

function listCustomerAction()
{
    load_view('listCustomer');
}

function listOrderAction()
{
    load_view('listOrder');
}

function menuAction()
{
    load_view('menu');
}

function addSliderAction()
{
    global $error;
    $error = [];
    
    if (isset($_POST['btn-submit'])) {
        // Validate data
        if (empty($_POST['title'])) {
            $error['title'] = "Không được để trống tên slider";
        }
        
        if (empty($_POST['num_order'])) {
            $error['num_order'] = "Không được để trống thứ tự";
        } elseif (!is_numeric($_POST['num_order'])) {
            $error['num_order'] = "Thứ tự phải là số";
        }
        
        // Xử lý upload ảnh
        $image = '';
        if(isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
            $upload_dir = 'public/uploads/sliders/';
            
            // Tạo thư mục nếu chưa tồn tại
            if(!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Kiểm tra định dạng file
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            
            if(!in_array($file_ext, $allowed_exts)) {
                $error['file'] = "Định dạng file không được hỗ trợ. Chỉ cho phép JPG, JPEG, PNG và GIF.";
            } 
            // Kiểm tra kích thước file (giới hạn 5MB)
            elseif($_FILES['file']['size'] > 5 * 1024 * 1024) {
                $error['file'] = "Kích thước file vượt quá 5MB.";
            }
            else {
                // Tạo tên file duy nhất
                $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;
                
                // Upload file
                if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
                    $image = $upload_path;
                } else {
                    $error['file'] = "Có lỗi xảy ra khi tải ảnh lên.";
                }
            }
        } else {
            $error['file'] = "Bạn phải chọn ảnh cho slider.";
        }
        
        // If no errors, proceed with adding slider
        if (empty($error)) {
            $data = [
                'title' => $_POST['title'],
                'desc' => $_POST['desc'],
                'image' => $image,
                'link' => $_POST['slug'],
                'num_order' => $_POST['num_order'],
                'status' => $_POST['status']
            ];
            
            add_slider($data);
            redirect("?mod=page&action=listSlider");
        }
    }
    
    load_view('addSlider');
}

function listSliderAction()
{
    $search = isset($_GET['s']) ? $_GET['s'] : '';
    $data = [
        'sliders' => get_sliders($search),
        'total_sliders' => count_sliders(),
        'published_sliders' => count_sliders_by_status(1),
        'pending_sliders' => count_sliders_by_status(2)
    ];
    load_view('listSlider', $data);
}

function editSliderAction()
{
    global $error;
    $error = [];
    
    $id = (int)$_GET['id'];
    if (!$id) {
        redirect("?mod=page&action=listSlider");
    }
    
    $slider = get_slider_by_id($id);
    if (!$slider) {
        redirect("?mod=page&action=listSlider");
    }
    
    if (isset($_POST['btn-submit'])) {
        // Validate data
        if (empty($_POST['title'])) {
            $error['title'] = "Không được để trống tên slider";
        }
        
        if (empty($_POST['num_order'])) {
            $error['num_order'] = "Không được để trống thứ tự";
        } elseif (!is_numeric($_POST['num_order'])) {
            $error['num_order'] = "Thứ tự phải là số";
        }
        
        // Xử lý upload ảnh
        $image = $slider['image']; // Keep the old image by default
        
        if(isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
            $upload_dir = 'public/uploads/sliders/';
            
            // Tạo thư mục nếu chưa tồn tại
            if(!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Kiểm tra định dạng file
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            
            if(!in_array($file_ext, $allowed_exts)) {
                $error['file'] = "Định dạng file không được hỗ trợ. Chỉ cho phép JPG, JPEG, PNG và GIF.";
            } 
            // Kiểm tra kích thước file (giới hạn 5MB)
            elseif($_FILES['file']['size'] > 5 * 1024 * 1024) {
                $error['file'] = "Kích thước file vượt quá 5MB.";
            }
            else {
                // Tạo tên file duy nhất
                $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $new_file_name;
                
                // Upload file
                if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
                    // Delete old image if it exists and is not the default
                    if(file_exists($slider['image']) && is_file($slider['image'])) {
                        @unlink($slider['image']);
                    }
                    $image = $upload_path;
                } else {
                    $error['file'] = "Có lỗi xảy ra khi tải ảnh lên.";
                }
            }
        }
        
        // If no errors, proceed with updating slider
        if (empty($error)) {
            $data = [
                'title' => $_POST['title'],
                'desc' => $_POST['desc'],
                'image' => $image,
                'link' => $_POST['slug'],
                'num_order' => $_POST['num_order'],
                'status' => $_POST['status']
            ];
            
            update_slider($id, $data);
            redirect("?mod=page&action=listSlider");
        }
    }
    
    $data = [
        'slider' => $slider
    ];
    
    load_view('editSlider', $data);
}

function deleteSliderAction()
{
    $id = (int)$_GET['id'];
    if ($id) {
        // Get slider to delete the image file
        $slider = get_slider_by_id($id);
        if ($slider) {
            // Delete the image file if it exists and is not the default
            if(file_exists($slider['image']) && is_file($slider['image'])) {
                @unlink($slider['image']);
            }
            delete_slider($id);
        }
    }
    
    redirect("?mod=page&action=listSlider");
}

function addWidgetAction()
{
    load_view('addWidget');
}

function listWidgetAction()
{
    load_view('listWidget');
}

function updateAction() {}
