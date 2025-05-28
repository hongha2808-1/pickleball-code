<?php get_header(); ?>

<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>">
                        <?php if(isset($error['title'])): ?>
                            <p class="error"><?php echo $error['title']; ?></p>
                        <?php endif; ?>
                        
                        <label for="slug">Link</label>
                        <input type="text" name="slug" id="slug" value="<?php echo isset($_POST['slug']) ? $_POST['slug'] : ''; ?>">
                        
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo isset($_POST['desc']) ? $_POST['desc'] : ''; ?></textarea>
                        
                        <label for="num_order">Thứ tự</label>
                        <input type="text" name="num_order" id="num-order" value="<?php echo isset($_POST['num_order']) ? $_POST['num_order'] : ''; ?>">
                        <?php if(isset($error['num_order'])): ?>
                            <p class="error"><?php echo $error['num_order']; ?></p>
                        <?php endif; ?>
                        
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb">
                            <?php if(isset($error['file'])): ?>
                                <p class="error"><?php echo $error['file']; ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <label>Trạng thái</label>
                        <select name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" <?php echo isset($_POST['status']) && $_POST['status'] == 1 ? 'selected' : ''; ?>>Công khai</option>
                            <option value="2" <?php echo isset($_POST['status']) && $_POST['status'] == 2 ? 'selected' : ''; ?>>Chờ duyệt</option>
                        </select>
                        
                        <button type="submit" name="btn-submit" id="btn-submit">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>