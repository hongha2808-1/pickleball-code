<?php get_header(); ?>

<div id="main-content-wp" class="add-cat-page slider-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa Slider</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <?php if(isset($slider) && $slider): ?>
                    <form method="POST" enctype="multipart/form-data">
                        <label for="title">Tên slider</label>
                        <input type="text" name="title" id="title" value="<?php echo $slider['title']; ?>">
                        <?php if(isset($error['title'])): ?>
                            <p class="error"><?php echo $error['title']; ?></p>
                        <?php endif; ?>
                        
                        <label for="slug">Link</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $slider['link']; ?>">
                        
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc" class="ckeditor"><?php echo $slider['desc']; ?></textarea>
                        
                        <label for="num_order">Thứ tự</label>
                        <input type="text" name="num_order" id="num-order" value="<?php echo $slider['num_order']; ?>">
                        <?php if(isset($error['num_order'])): ?>
                            <p class="error"><?php echo $error['num_order']; ?></p>
                        <?php endif; ?>
                        
                        <label>Hình ảnh</label>
                        <div id="uploadFile">
                            <input type="file" name="file" id="upload-thumb">
                            <?php if(isset($error['file'])): ?>
                                <p class="error"><?php echo $error['file']; ?></p>
                            <?php endif; ?>
                            <img src="<?php echo $slider['image']; ?>" alt="Current slider image" width="300">
                        </div>
                        
                        <label>Trạng thái</label>
                        <select name="status">
                            <option value="1" <?php echo $slider['status'] == 1 ? 'selected' : ''; ?>>Công khai</option>
                            <option value="2" <?php echo $slider['status'] == 2 ? 'selected' : ''; ?>>Chờ duyệt</option>
                        </select>
                        
                        <button type="submit" name="btn-submit" id="btn-submit">Cập nhật</button>
                    </form>
                    <?php else: ?>
                    <p>Không tìm thấy slider.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?> 