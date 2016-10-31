<?php
session_start();
require_once '../dbconnect.inc';
if(isset($_SESSION['AUTH_PERMISSION_ID'])==false or $_SESSION['AUTH_PERMISSION_TYPE'] != 1) {
	echo "<script>location.href='index.php'</script>";
}

 $num =0;
$result=null;
$mess="";
if(isset($_GET['invoice_no']) && $_GET['invoice_no'] != ''){
        $sql= "select * from order_tb 
                    where order_acc = '1'  AND invoice_no ='" . $_GET['invoice_no'] ."' group by order_number order by invoice_no";
                $result = @mysql_query($sql, $connect);
                $num =@mysql_num_rows($result);
}
else if(isset($_GET['start']) && isset($_GET['end']) && $_GET['start'] != '' && $_GET['end'] != ''){
     $sql= "select * from order_tb 
                    where order_acc = '1'  AND payment_date >='" . $_GET['start'] ."' AND payment_date <= '" . $_GET['end'] ."' group by order_number order by invoice_no";
                $result = @mysql_query($sql, $connect);
                $num =@mysql_num_rows($result);
    
}
else{
    
    $mess = 'เงื่อนไขการค้นหาไม่ถูกต้อง';
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>::Crosstwelfth::</title>
<style type="text/css">
div.inline { float:left; }
.clearBoth { clear:both; }

table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;
}

</style>
<div class
</head>
<body>
<div >
    <?php  
    if($mess != ''){ echo $mess;}
    else if($num<=0) { echo 'ไม่พบข้อมูล';}
    for($i=1;$i<=intval($num);$i++){
    $data =@mysql_fetch_array($result); ?>
        <div style="page-break-after: always;">
             <?php if($data['order_status'] == 0){ ?>
                <div style="width: 100%;text-align: center" class="clearBoth">
                    <h1 style="color:red">ยกเลิก</h1>
                </div>
            <?php }  ?>
            <div style="width: 100%;" class="clearBoth">
                <div class="inline" style="width: 50%;"><div class="banner_celleb-modish">
       	    <img src="images/Crosstwelfth_Logo.png" width="87" height="77" /></div></div>
                <div class="inline" style="width: 50%;text-align: right"><h2>ใบกำกับภาษี/ใบเสร็จรับเงิน<br>สำเนา</h2></div>
            </div>
            <div style="width: 100%" class="clearBoth">
                <div class="inline" style="width: 60%;">
                    <b> บริษัท ครอส ทเวลฟ์ จำกัด </b><br>
                    692 ถนนอนามัยงานเจริญ <br>
                    แขวงท่าข้าม เขตบางขุนเทียน 10150<br>
                    เลขประจำตัวผู้สียภาษี 1111111111111 (สำนักงานใหญ่)
                </div>
                <div class="inline" style="width: 40%;">
                    <div class="inline"  style="width: 30%;">เลขที่ </div>
                    <div class="inline"  style="width: 70%;"> <?php echo $data['invoice_no'];?></div>
                    <br class="clearBoth"> <div class="inline"  style="width: 30%;">วันที่</div>
                    <div class="inline"  style="width: 70%;"> <?php echo date("d/m/Y", strtotime($data['payment_date']));?></div>
                    <br>
                </div>
            </div>
            <br class="clearBoth"><br class="clearBoth">
            <div style="width: 100%" class="clearBoth">
                <div class="inline" style="width: 60%;">
                    <b>ลูกค้า</b> <br>
                    <?php 
                    $pos = strpos($data['order_address1'],"เบอร์โทร");
                    if($pos)
                    {
                            $address = substr($data['order_address1'],0,$pos); 
                    echo ereg_replace('<br>รหัสไปรษณีย์ : ',' ',ereg_replace('ชื่อ : ','',ereg_replace('ที่อยู่ : ','',ereg_replace('จังหวัด : ',' ',$address)))); 
                    }
                    else{
                        echo ereg_replace('<br>รหัสไปรษณีย์ : ',' ',ereg_replace('ชื่อ : ','',ereg_replace('ที่อยู่ : ','',ereg_replace('จังหวัด : ',' ',$data['order_address1'])))); 
                    }
                    ?> 
                </div>
               <div class="inline" style="width: 40%;display: none">
                    <div class="inline"  style="width: 30%;">เลขที่ออเดอร์ </div>
                    <div class="inline"  style="width: 70%;"> <?php echo $data['order_number']; ?></div>
                </div>
            </div>
            
            <table style="width: 100%;">
                <thead>
                <tr>
                    <th style="width: 5%">
                        #
                    </th>
                    <th style="width: 35%">
                        รายละเอียด
                    </th>
                    <th style="width: 10%">
                        จำนวน
                    </th>
                    <th style="width: 25%">
                        ราคาต่อหน่วย
                    </th>
                    <th style="width: 25%">
                        ยอดรวม
                    </th>
                </tr>
                </thead>
                 <tbody>
            <?php 

                $sql2= "select * from order_product_tb  
                    where order_number = '" .  trim($data['order_number']) . "'";
                           
                $result2= @mysql_query($sql2, $connect);
                $num2 =@mysql_num_rows($result2);
                $subtotal=0;
                
                $sql_color = "select c_code,name from color_tb";
                $result_color = @mysql_query($sql_color, $connect);
                $data_color =@mysql_num_rows($result_color);										

                    for ($o_c=1; $o_c<=$data_color; $o_c++) {
                            $c =@mysql_fetch_array($result_color);
                            $arr_color[$c['c_code']] = $c['name']; 
                    }
                  for($j=1;$j<=intval($num2);$j++){
                    $data2 =@mysql_fetch_array($result2); 
                    
                    $price = round($data2['order_p_price'] / 1.07,2);
                    $total = round($price * $data2['order_p_stock'],2);
                    $subtotal += $total;
                    
            ?> 
                     <tr>
                         <td><?php echo $j;?> </td>
                         <td>
                             <?php echo $data2['pro_code'] . " " . $arr_color[$data2['order_p_color']] . " " . $data2['order_p_size'];?> 
                          </td>  
                          <td style="text-align: right">
                             <?php echo $data2['order_p_stock'];?> 
                          </td> 
                         <td style="text-align: right">
                             <?php echo number_format($price, 2);?> 
                          </td>
                         <td style="text-align: right">
                             <?php echo  number_format($total, 2);?> 
                          </td>
                     </tr>  
            <?php } 
            
                
                $subtotal = round($subtotal,2);
                $discount = $data['order_promotion'] > 0 ? round($subtotal * $data['order_promotion'],2) / 100 : 0;
                $total = $subtotal - $discount;
                $vat =      round($total * .07,2);
                $grand = round($total+ $vat,2);
                
             // if $grand has decimail equal .01 or .99 then will change vat decimal. 
                $fraction = explode('.', number_format($grand, 2));
                
                if($fraction[1] == '01')
                {
                     $vat = $vat -.01;
                     $grand  = round($total+ $vat,2);
                }
                else if($fraction[1] == '99')
                {
                     $vat = $vat +.01;
                      $grand  = round($total+ $vat,2);
                }
                if($data['order_promotion'] > 0){
            ?>
                     
                     <tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td style="text-align: right">ส่วนลด <?php echo $data['order_promotion'];?> %</td>
                          <td style="text-align: right">  <?php echo  number_format($discount, 2);?> บาท</td>
                     </tr>
            <?php }  ?>    
                     <tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td style="text-align: right">รวมเงิน</td>
                          <td style="text-align: right">  <?php echo  number_format($total, 2);?> บาท</td>
                     </tr>
                     <tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td style="text-align: right">ภาษีมูลค่าเพิ่ม 7%</td>
                         <td style="text-align: right">  <?php echo  number_format($vat, 2);?> บาท</td>
                     </tr>
                     
                     <tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td style="text-align: right">ยอดเงินสุทธิ</td>
                         <td style="text-align: right">  <?php echo number_format($grand, 2);?> บาท</td>
                     </tr>
                </tbody>
            </table>
            <div class="clearBoth" style="margin-top: 25px;width: 100%;text-align: right;">
                ในนาม บริษัท ครอส ทเวลฟ์ จำกัด
            </div>
             <div class="clearBoth" style="margin-top: 25px;width: 100%;text-align: center;">
                 <div class="inline" style="width: 100px;border-top: 1px solid #000;">ผู้รับสินค้า</div> 
                <div class="inline" style="margin-left: 10px;width: 100px;border-top: 1px solid #000;">วันที่</div>
                 <div  style="float:right;margin-left: 10px;width: 100px;border-top: 1px solid #000;">วันที่</div>
                 <div  style="float:right;width: 100px;border-top: 1px solid #000;">ผู้อนุมัติ</div> 
            </div>
                <div class="clearBoth" style="width: 100%;text-align: left;">
                    <div class="inline" >หมายเหตุ : </div>
                 <div class="inline" > <?php echo $data['invoice_remark'] != '' ? $data['invoice_remark']:'-';?></div> 
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>