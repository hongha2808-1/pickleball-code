<?php

function construct() {
    // Không cần load model
}

function uploadImageAction() {
    $result = [
        'success' => false,
        'file_path' => '',
        'error' => ''
    ];
    
    // Kiểm tra xem có file được gửi lên không
    if (!isset($_FILES['file']) || $_FILES['file']['error'] > 0) {
        $result['error'] = "Không có file được tải lên hoặc file lỗi.";
        echo json_encode($result);
        die();
    }
    
    // Lấy thông tin file
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    
    // Kiểm tra định dạng file (cho phép jpg, jpeg, png, gif)
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($file_ext, $allowed_exts)) {
        $result['error'] = "Định dạng file không được hỗ trợ. Chỉ cho phép JPG, JPEG, PNG và GIF.";
        echo json_encode($result);
        die();
    }
    
    // Kiểm tra kích thước file (giới hạn 5MB)
    if ($file_size > 5 * 1024 * 1024) {
        $result['error'] = "Kích thước file vượt quá 5MB.";
        echo json_encode($result);
        die();
    }
    
    // Thay vì mã hóa base64, lưu file vào thư mục uploads
    $upload_dir = 'public/uploads/';
    
    // Tạo thư mục nếu chưa tồn tại
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Tạo tên file duy nhất để tránh trùng lặp
    $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
    $upload_path = $upload_dir . $new_file_name;
    
    // Di chuyển file tải lên vào thư mục đích
    if (move_uploaded_file($file_tmp, $upload_path)) {
        $result['success'] = true;
        $result['file_path'] = $upload_path;
    } else {
        $result['error'] = "Có lỗi xảy ra khi lưu file. Vui lòng thử lại.";
    }
    
    // Trả về kết quả dạng JSON
    echo json_encode($result);
    die();
} 