<?php
$c['config'] = include('setting_date.php');
//$start_week_ts = mktime($c['config']['SUMMARY_START_HOUR_SETTING'], 0, 0, date('n'),
//    date('j') - date('N')) - $c['config']['WEEK_TS'] + ($c['config']['DAY_TS'] * $c['config']['SUMMARY_START_WEEK_SETTING']);

$d = date('j') - date('N');
$start_week_ts = strtotime(date("Y") . "-" . date('n') . "-" . $d) - $c['config']['WEEK_TS'] + ($c['config']['DAY_TS'] * $c['config']['SUMMARY_START_WEEK_SETTING']);

//print_r(date('n'));
//print_r("=========");
//print_r(date('j'));
//print_r("=========");
//print_r(date('N'));


return [
    'MAIL_FROM' => env('MAIL_FROM_ADDRESS', null),
    'FILTER_BY_DAY' => 'day',
    'FILTER_BY_WEEK' => 'week',
    'FILTER_BY_MONTH' => 'month',

    'PROCESSING' => 'processing',
    'COMPLETED' => 'completed',
    'IMAGE_DEFAULT' => '/admin/image/placeholder.png',
    'ERROR_MSG_401' => 'Không có quyền!',
    'ERROR_MSG_404' => 'Không tìm thấy trang!',
    'ERROR_MSG_UNKNOWN' => 'Đã có lỗi xảy ra!',

    'MANAGER_PRODUCT' => 'Quản lý sản phẩm',
    'MANAGER_ORDER' => 'Quản lý đơn hàng',
    'MANAGER_COMPANY_SUPPLY' => 'Quản lý công ty cung cấp',
    'MANAGER_SUPPLY_WAREHOUSE' => 'Quản lý kho',
    'MANAGER_EMPLOYEE' => 'Quản lý nhân viên',
    'MANAGER_IMPORT_COMPANY' => 'Quản lý đại lý',
    'MANAGER_USERS' => 'Quản lý người dùng',
    'MANAGER_ROLES' => 'Quản lý nhóm quyền',
    'MANAGER_PERMISSIONS' => 'Quản lý quyền',


    'LIST_PERMISSION' => 'Danh sách quyền',
    'LIST_PRODUCT' => 'Danh sách sản phẩm',
    'LIST_ORDER' => 'Danh sách đơn hàng',
    'LIST_COMPANY_SUPPLY' => 'Danh sách công ty cung cấp',
    'LIST_SUPPLY_WAREHOUSE' => 'Danh sách kho',
    'LIST_EMPLOYEE' => 'Danh sách nhân viên',
    'LIST_IMPORT_COMPANY' => 'Danh sách đại lý',
    'LIST_USERS' => 'Danh sách người dùng',
    'LIST_ROLES' => 'Danh sách nhóm quyền',
    'LIST_PERMISSIONS' => 'Danh sách quyền',

    //PERMISSION
    'PERMISSION' => 'Quản lý quyền',
    'LIST_PERMISSION' => 'DS quyền',
    'ADD_PERMISSION' => 'Thêm quyền',
    'EDIT_PERMISSION' => 'Sửa quyền',
    'DELETE_PERMISSION' => 'Xóa quyền',

    // ROLE
    'ROLE' => 'Quản lý nhóm quyền',
    'LIST_ROLE' => 'DS nhóm quyền',
    'ADD_ROLE' => 'Thêm nhóm quyền',
    'EDIT_ROLE' => 'Sửa nhóm quyền',
    'DELETE_ROLE' => 'Xóa nhóm quyền',

    // USER
    'USER' => 'Quản lý người dùng',
    'LIST_USER' => 'DS người dùng',
    'ADD_USER' => 'Thêm người dùng',
    'EDIT_USER' => 'Sửa người dùng',
    'DELETE_USER' => 'Xóa người dùng',
    'RESET_USER' => 'Reset người dùng',

    // GENRE
    'GENRE' => 'Quản lý thể loại tin tức',
    'LIST_GENRE' => 'Xem danh sách thể loại tin tức',
    'ADD_GENRE' => 'Thêm thể loại tin tức',
    'EDIT_GENRE' => 'Sửa thể loại tin tức',
    'DELETE_GENRE' => 'Xóa thể loại tin tức',

    // ADS
    'ADS' => 'Quản lý quảng cáo',
    'LIST_ADS' => 'Xem danh sách quảng cáo',
    'ADD_ADS' => 'Thêm quảng cáo',
    'EDIT_ADS' => 'Sửa quảng cáo',
    'DELETE_ADS' => 'Xóa quảng cáo',

    // ADS_POSITION
    'ADS_POSITION' => 'Quản lý vị trí quảng cáo',
    'LIST_ADS_POSITION' => 'Xem danh sách vị trí quảng cáo',
    'ADD_ADS_POSITION' => 'Thêm vị trí quảng cáo',
    'EDIT_ADS_POSITION' => 'Sửa vị trí quảng cáo',
    'DELETE_ADS_POSITION' => 'Xóa vị trí quảng cáo',

    // VIDEO
    'VIDEO' => 'Quản lý hình ảnh video',
    'LIST_VIDEO' => 'Xem danh sách hình ảnh video',
    'ADD_VIDEO' => 'Thêm danh sách hình ảnh video',
    'EDIT_VIDEO' => 'Sửa danh sách hình ảnh video',
    'DELETE_VIDEO' => 'Xóa danh sách hình ảnh video',

    // PARTNER
    'PARTNER' => 'Quản lý đối tác',
    'LIST_PARTNER' => 'Xem danh sách đối tác',
    'ADD_PARTNER' => 'Thêm danh sách đối tác',
    'EDIT_PARTNER' => 'Sửa danh sách đối tác',
    'DELETE_PARTNER' => 'Xóa danh sách đối tác',

    // LINKED
    'LINKED' => 'Quản lý liên kết',
    'LIST_LINKED' => 'Xem danh sách liên kết',
    'ADD_LINKED' => 'Thêm danh sách liên kết',
    'EDIT_LINKED' => 'Sửa danh sách liên kết',
    'DELETE_LINKED' => 'Xóa danh sách liên kết',

    // FEEDBACK
    'FEEDBACK' => 'Quản lý liên hệ',
    'LIST_FEEDBACK' => 'Xem danh sách liên hệ',
    'EDIT_FEEDBACK' => 'Sửa danh sách liên hệ',
    'DELETE_FEEDBACK' => 'Xóa danh sách liên hệ',

    // COMMENT
    'COMMENT' => 'Quản lý bình luận',
    'LIST_COMMENT' => 'Xem danh sách bình luận',
    'EDIT_COMMENT' => 'Sửa danh sách bình luận',
    'DELETE_COMMENT' => 'Xóa danh sách bình luận',

    // SECURITY
    'SECURITY' => 'Quản lý hỗ trợ bảo mật',
    'LIST_SECURITY' => 'Xem danh sách hỗ trợ bảo mật',
    'ADD_SECURITY' => 'Thêm danh sách hỗ trợ và bảo mật',
    'EDIT_SECURITY' => 'Thêm danh sách hỗ trợ và bảo mật',
    'DELETE_SECURITY' => 'Xóa danh sách hỗ trợ và bảo mật',

    //category
    'CATEGORY' => 'Quản lý danh mục',
    'LIST_CATEGORY' => 'Xem danh sách danh mục',
    'ADD_CATEGORY' => 'Thêm danh mục',
    'EDIT_CATEGORY' => 'Sửa danh mục',
    'DELETE_CATEGORY' => 'Xóa danh mục',

    //news
    'NEWS' => 'Quản lý bài viết',
    'LIST_NEWS' => 'Xem danh sách bài viết',
    'ADD_NEWS' => 'Thêm bài viết',
    'EDIT_NEWS' => 'Sửa bài viết',
    'DELETE_NEWS' => 'Xóa bài viết',
    'DETAIL_NEWS' => 'Chi tiết bài viết',
    'RECALL_NEWS' => 'Gỡ bài viết',
    'REVIEW_NEWS' => 'Duyệt/ Từ chối bài viết',
    'APPROVAL_NEWS' => 'Gửi duyệt bài viết',


    // common
    'MANAGEMENT' => 'Quản lý',
    'CONTENT_MANAGEMENT' => 'Quản lý nội dung',
    'STATISTIC' => 'Báo cáo thống kê',


    // Xóa bộ đệm
    'CACHE' => 'Xóa bộ đệm',
    // Cài đặt chung
    'SETUP_DEFAULT' => 'Quản lý cài đặt',

];
