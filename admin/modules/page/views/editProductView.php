<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa sản phẩm</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="product_title">Tên sản phẩm</label>
                        <input type="text" name="product_title" id="product_title" value="<?php echo isset($_POST['product_title']) ? $_POST['product_title'] : $product['product_title']; ?>">
                        <?php echo isset($error['product_title']) ? "<p class='error'>{$error['product_title']}</p>" : ""; ?>
                        
                        <label for="price_new">Giá mới</label>
                        <input type="text" name="price_new" id="price_new" value="<?php echo isset($_POST['price_new']) ? $_POST['price_new'] : $product['price_new']; ?>">
                        <?php echo isset($error['price_new']) ? "<p class='error'>{$error['price_new']}</p>" : ""; ?>
                        
                        <label for="price_old">Giá cũ (để trống nếu không có)</label>
                        <input type="text" name="price_old" id="price_old" value="<?php echo isset($_POST['price_old']) ? $_POST['price_old'] : $product['price_old']; ?>">
                        <?php echo isset($error['price_old']) ? "<p class='error'>{$error['price_old']}</p>" : ""; ?>
                        
                        <label for="product_desc">Mô tả ngắn</label>
                        <textarea name="product_desc" id="product_desc"><?php echo isset($_POST['product_desc']) ? $_POST['product_desc'] : $product['product_desc']; ?></textarea>
                        <?php echo isset($error['product_desc']) ? "<p class='error'>{$error['product_desc']}</p>" : ""; ?>
                        
                        <label for="product_content">Chi tiết</label>
                        <textarea name="product_content" id="product_content" class="ckeditor"><?php echo isset($_POST['product_content']) ? $_POST['product_content'] : $product['product_content']; ?></textarea>
                        
                        <label>Hình ảnh</label>
                        <div id="uploadFile" style="margin-bottom: 15px;">
                            <div class="custom-file-upload">
                                <input type="file" name="product_thumb" id="product_thumb" accept="image/*" style="margin-bottom: 10px;">
                                <p class="file-info" style="color: #666; font-size: 13px;">Chấp nhận: JPG, JPEG, PNG, GIF. Tối đa: 5MB.</p>
                            </div>
                            <?php if(isset($error['product_thumb'])): ?>
                                <p class="error" style="color: red;"><?php echo $error['product_thumb']; ?></p>
                            <?php endif; ?>
                            
                            <?php if(isset($uploaded_image) && !empty($uploaded_image)): ?>
                                <div id="current-image" style="margin-top: 15px;">
                                    <p style="font-weight: bold; margin-bottom: 5px;">Ảnh mới tải lên:</p>
                                    <img src="<?php echo $uploaded_image; ?>" alt="Preview" style="max-width: 200px; border: 1px solid #ddd; padding: 3px; border-radius: 3px;">
                                </div>
                            <?php elseif(!empty($product['product_thumb'])): ?>
                                <div id="current-image" style="margin-top: 15px;">
                                    <p style="font-weight: bold; margin-bottom: 5px;">Ảnh hiện tại:</p>
                                    <img src="<?php echo $product['product_thumb']; ?>" alt="<?php echo $product['product_title']; ?>" style="max-width: 200px; border: 1px solid #ddd; padding: 3px; border-radius: 3px;">
                                    <input type="hidden" name="old_product_thumb" value="<?php echo $product['product_thumb']; ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <label>Danh mục sản phẩm</label>
                        <select name="cat_id">
                            <option value="">-- Chọn danh mục --</option>
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo (isset($_POST['cat_id']) && $_POST['cat_id'] == $category['id']) || $product['cat_id'] == $category['id'] ? 'selected' : ''; ?>><?php echo $category['cat_title']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php echo isset($error['cat_id']) ? "<p class='error'>{$error['cat_id']}</p>" : ""; ?>
                        
                        <label>Sản phẩm nổi bật</label>
                        <div class="check-box">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo (isset($_POST['is_featured']) || $product['is_featured'] == 1) ? 'checked' : ''; ?>>
                            <label for="is_featured">Nổi bật</label>
                        </div>
                        
                        <button type="submit" name="btn-update" id="btn-submit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 