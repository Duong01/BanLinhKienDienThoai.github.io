<?php
include_once '../lib/session.php';
Session::checkSession('admin');
$role_id = Session::get('role_id');
if ($role_id == 1) {
    # code...
} else {
    header("Location:../index.php");
}
include '../classes/order.php';

$order = new order();
$processingOrderList = $order->getProcessingOrder();
$processedOrderList = $order->getProcessedOrder();
$deliveringOrderList = $order->getDeliveringOrder();
$completeOrderList = $order->getCompleteOrder();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title>Quản lý đơn đặt hàng</title>
</head>

<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">ADMIN</label>
        <ul>
            <li><a href="productlist.php">Quản lý Sản phẩm</a></li>
            <li><a href="categoriesList.php">Quản lý Danh mục</a></li>
            <li><a href="orderlist.php" class="active">Quản lý Đơn hàng</a></li>
            <li><a href="userlist.php">Quản lý Người dùng</a></li>
            <li><a href="../index.php">Quay lại trang chủ</a></li>

        </ul>
    </nav>
    <div class="title">
        <h1>Danh sách đơn đặt hàng</h1>
    </div>
    <div class="container">
        <!-- Tab links -->
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Processing')">Đang xử lý</button>
            <button class="tablinks" onclick="openTab(event, 'Processed')">Đã xử lý</button>
            <button class="tablinks" onclick="openTab(event, 'Delivering')">Đang giao hàng</button>
            <button class="tablinks" onclick="openTab(event, 'Complete')">Đã hoàn thành</button>
            <button class="tablinks" onclick="openTab(event, 'Thongke')">Thống kê</button>
        </div>

        <!-- Tab content -->
        <div id="Processing" class="tabcontent">
            <?php
            if ($processingOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                        <th>In</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($processingOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?=  ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                            </td>
                            <td>
                                <a href="indonhang.php?orderId?code=<?= $value['id'] ?>">In hóa đơn</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang xử lý</h3>
            <?php }
            ?>
        </div>

        <div id="Processed" class="tabcontent">
            <?php
            if ($processedOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($processedOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?=  ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="delivering_order.php?orderId=<?= $value['id'] ?>">Giao hàng</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đã xử lý</h3>
            <?php }
            ?>
        </div>

        <div id="Delivering" class="tabcontent">
            <?php
            if ($deliveringOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày nhận</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($deliveringOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?=  ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đang giao</h3>
            <?php }
            ?>
        </div>

        <div id="Complete" class="tabcontent">
            <?php
            if ($completeOrderList) { ?>
                <table class="list">
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Ngày nhận</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php $count = 1;
                    foreach ($completeOrderList as $key => $value) { ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['createdDate'] ?></td>
                            <td><?= ($value['status'] != "Processing") ? $value['receivedDate'] : "Dự kiến 3 ngày sau khi đơn hàng đã được xử lý" ?> <?=  ($value['status'] != "Complete" && $value['status'] != "Processing") ? "(Dự kiến)" : "" ?> </td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <a href="orderlistdetail.php?orderId=<?= $value['id'] ?>">Chi tiết</a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php } else { ?>
                <h3>Chưa có đơn hàng nào đã hoàn thành</h3>
            <?php }
            ?>
        </div>
        <div id="Thongke" class="tabcontent">
            <p>THỐNG KÊ ĐƠN HÀNG: </p>
            <div id="mychart" style="height: 250px;"></div>
        </div>
    </div>
    </div>
    
    <footer>
        <p class="copyright"></p>
    </footer>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type="text/javascript">
    new Morris.Line({
    // ID of the element in which to draw the chart.
    element: 'mychart',
    // Chart data records -- each entry in this array corresponds to a point on
    // the chart.
    data: [
        { year: '2021', value: 20 },
        { year: '2022', value: 10 },
        { year: '2023', value: 5 },
        { year: '2024', value: 5 },
    ],
    // The name of the data record attribute that contains x-values.
    xkey: 'year',
    // A list of names of data record attributes that contain y-values.
    ykeys: ['value'],
    // Labels for the ykeys -- will be displayed when you hover over the
    // chart.
    labels: ['Value']
    });
</script>
<script type="text/javascript">
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 1; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        document.getElementById(tabName).style.display = "block";
    }
</script>

</html>