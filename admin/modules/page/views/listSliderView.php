<?php get_header(); ?>

<div id="main-content-wp" class="list-product-page list-slider">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Danh sách slider</h3>
                    <a href="?mod=page&action=addSlider" title="" id="add-new" class="fl-left">Thêm mới</a>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <div class="filter-wp clearfix">
                        <ul class="post-status fl-left">
                            <li class="all"><a href="?mod=page&action=listSlider">Tất cả <span class="count">(<?php echo $total_sliders; ?>)</span></a> |</li>
                            <li class="publish"><a href="?mod=page&action=listSlider&status=1">Đã đăng <span class="count">(<?php echo $published_sliders; ?>)</span></a> |</li>
                            <li class="pending"><a href="?mod=page&action=listSlider&status=2">Chờ xét duyệt<span class="count">(<?php echo $pending_sliders; ?>)</span></a></li>
                        </ul>
                        <form method="GET" class="form-s fl-right">
                            <input type="hidden" name="mod" value="page">
                            <input type="hidden" name="action" value="listSlider">
                            <input type="text" name="s" id="s" value="<?php echo isset($_GET['s']) ? $_GET['s'] : ''; ?>">
                            <input type="submit" name="sm_s" value="Tìm kiếm">
                        </form>
                    </div>
                    <div class="actions">
                        <form method="GET" action="" class="form-actions">
                            <select name="actions">
                                <option value="0">Tác vụ</option>
                                <option value="1">Công khai</option>
                                <option value="1">Chờ duyệt</option>
                                <option value="2">Bỏ vào thủng rác</option>
                            </select>
                            <input type="submit" name="sm_action" value="Áp dụng">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table list-table-wp">
                            <thead>
                                <tr>
                                    <td><span class="thead-text">STT</span></td>
                                    <td><span class="thead-text">Tiêu đề</span></td>
                                    <td><span class="thead-text">Hình ảnh</span></td>
                                    <td><span class="thead-text">Link</span></td>
                                    <td><span class="thead-text">Thứ tự</span></td>
                                    <td><span class="thead-text">Trạng thái</span></td>
                                    <td><span class="thead-text">Thao tác</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sliders)) : ?>
                                    <?php $counter = 1; ?>
                                    <?php foreach ($sliders as $slider) : ?>
                                        <tr>
                                            <td><span class="tbody-text"><?php echo $counter++; ?></span></td>
                                            <td><span class="tbody-text"><?php echo $slider['title']; ?></span></td>
                                            <td>
                                                <div class="tbody-thumb">
                                                    <img src="<?php echo $slider['image']; ?>" alt="<?php echo $slider['title']; ?>">
                                                </div>
                                            </td>
                                            <td class="clearfix">
                                                <div class="tb-title fl-left">
                                                    <a href="<?php echo $slider['link']; ?>" title=""><?php echo $slider['link']; ?></a>
                                                </div>
                                            </td>
                                            <td><span class="tbody-text"><?php echo $slider['num_order']; ?></span></td>
                                            <td>
                                                <span class="tbody-text">
                                                    <?php 
                                                    if ($slider['status'] == 1) {
                                                        echo "Công khai";
                                                    } elseif ($slider['status'] == 2) {
                                                        echo "Chờ duyệt";
                                                    } else {
                                                        echo "Không xác định";
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td>
                                                <ul class="list-operation fl-right">
                                                    <li><a href="?mod=page&action=editSlider&id=<?php echo $slider['id']; ?>" title="Sửa" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                                                    <li><a href="?mod=page&action=deleteSlider&id=<?php echo $slider['id']; ?>" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa slider này?')"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7"><span class="tbody-text">Không có slider nào</span></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><span class="tfoot-text">STT</span></td>
                                    <td><span class="tfoot-text">Tiêu đề</span></td>
                                    <td><span class="tfoot-text">Hình ảnh</span></td>
                                    <td><span class="tfoot-text">Link</span></td>
                                    <td><span class="tfoot-text">Thứ tự</span></td>
                                    <td><span class="tfoot-text">Trạng thái</span></td>
                                    <td><span class="tfoot-text">Thao tác</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail clearfix">
                    <p id="desc" class="fl-left">Chọn vào checkbox để lựa chọn tất cả</p>
                    <ul id="list-paging" class="fl-right">
                        <li>
                            <a href="" title="">
                                << /a>
                        </li>
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                        <li>
                            <a href="" title="">></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>