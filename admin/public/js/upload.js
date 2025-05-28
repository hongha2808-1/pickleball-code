/* 
 * File này không còn cần thiết vì upload được xử lý trực tiếp bởi backend PHP.
 * Dữ liệu được gửi thông qua form submit với enctype="multipart/form-data".
 */ 

$(document).ready(function() {
    // Xử lý xem trước hình ảnh khi chọn file
    $('#product_thumb').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewHtml = '<img src="' + e.target.result + '" alt="Preview" style="max-width: 200px; margin-top: 10px;">';
                
                // Nếu có container preview từ trước, cập nhật nó
                if ($('#image-preview').length) {
                    $('#image-preview').html(previewHtml);
                } else {
                    // Nếu chưa có, tạo mới và thêm vào sau input file
                    $('<div id="image-preview" style="margin-top: 10px;">' + previewHtml + '</div>').insertAfter('#product_thumb');
                }
            };
            reader.readAsDataURL(file);
        }
    });
}); 