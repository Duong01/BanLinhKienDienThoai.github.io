<?php
require('../tfpdf/tfpdf.php');
// include('../config/config.php');

$pdf = new tFPDF();
$pdf->AddPage("0");
// $pdf->SetFont('Arial','B',16);
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',14);
// $pdf->Cell(40,10,'Hello World !');
$pdf->Write(10,'Đơn hàng của bạn gồm có:');
	$pdf->Ln(10);
   
    $pdf->Cell(10,10,'ID',1);
    $pdf->Cell(90,10,'Tên sản phẩm',1);
    $pdf->Cell(40,10,'Đơn giá',1);
    $pdf->Cell(40,10,'Số lượng',1);
    $pdf->Cell(40,10,'Thành tiền',1);
	$pdf->Ln(10);
    $i=0;
    
	//$width_cell=array(5,80,20,30,40);

	// $pdf->Cell($width_cell[0],10,'ID',1,0,'C',true);
	// $pdf->Cell($width_cell[1],10,'Tên sản phẩm',1,0,'C',true);
	// $pdf->Cell($width_cell[2],10,'Giá',1,0,'C',true);
	// $pdf->Cell($width_cell[3],10,'Số lượng',1,0,'C',true); 
	// $pdf->Cell($width_cell[4],10,'Tổng tiền',1,1,'C',true); 
	// $pdf->SetFillColor(235,236,236); 
	// $fill=false;
	// $i = 0;
	// while($row = mysqli_fetch_array($query_lietke_dh)){
	// 	$i++;
	// $pdf->Cell($width_cell[0],10,$i,1,0,'C',$fill);
	// $pdf->Cell($width_cell[1],10,$row['code_cart'],1,0,'C',$fill);
	// $pdf->Cell($width_cell[2],10,$row['tensanpham'],1,0,'C',$fill);
	// $pdf->Cell($width_cell[3],10,$row['soluongmua'],1,0,'C',$fill);
	// $pdf->Cell($width_cell[4],10,number_format($row['giasp']),1,0,'C',$fill);
	// $pdf->Cell($width_cell[5],10,number_format($row['soluongmua']*$row['giasp']),1,1,'C',$fill);
	// $fill = !$fill;

	// }
    $pdf->Write(10,'Cảm ơn bạn đã đặt hàng tại website của chúng tôi.');
	$pdf->Ln(10);
$pdf->Output();
?>
    <?php
    include_once '../lib/session.php';
    Session::checkSession('admin');
    $role_id = Session::get('role_id');
    if ($role_id == 1) {
        # code...
    } else {
        header("Location:../index.php");
    }
    include '../classes/orderDetails.php';
    include '../classes/order.php';
    
    $orderDetails = new orderDetails();
    $result = $orderDetails->getOrderDetails($_GET['orderId']);
    $order = new order();
    $order_result = $order->getById($result[0]['orderId']);
        if ($result) { ?>
            <table class="list">
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                </tr>
                <?php $count = 1;
                foreach ($result as $key => $value) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $value['productName'] ?></td>
                        <td><img class="image-cart" src="uploads/<?= $value['productImage'] ?>" alt=""></td>
                        <td><?= $value['productPrice'] ?></td>
                        <td><?= $value['qty'] ?></td>

                    </tr>
                <?php }
                ?>
            </table>
            <?php
            if ($order_result['status'] == 'Processing') { ?>
                <a href="processed_order.php?orderId=<?= $_GET['orderId'] ?>">Xác nhận</a>
            <?php }
            ?>
        <?php } else { ?>
            <h3>Chưa có đơn hàng nào đang xử lý</h3>
        <?php }
        ?>

