<?php
$a = explode('/',$_SERVER['REQUEST_URI']);
?>
			<div class="content_l">

               
                <div class="menu">
                	<a href="#">ORDER</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                  <a href="new_order.php">
                                      <li>รายการสั่งซื้อทั้งหมด</li>
                                  </a>
                                  <?php if ($_SESSION['AUTH_PERMISSION_TYPE'] == 1) {?>
                                  <a href="payment.php" target="_blank">
                                      <li>แจ้งชำระเงิน</li>
                                  </a>
                                  <?php }?>
                                  <a href="readytosent.php">
                                      <li>อัพเดท รายการจัดส่ง</li>
                                  </a>
								  <a href="readytosent2.php">
                                      <li>อัพเดท รายการจัดส่ง (ใหม่)</li>
                                  </a>
                                  <a href="tracking.php">
                                      <li>อัพเดท เลขพัสดุ</li>
                                  </a>
                                  <a href="tracking2.php">
                                      <li>อัพเดท เลขพัสดุ (ใหม่)</li>
                                  </a>
                                  <a href="printsent.php">
                                      <li>พิมพ์ รายการจัดส่ง</li>
                                  </a>
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>   
                <div class="menu">
                	<a href="#">MEMBER</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                  <a href="new_user.php">
                                      <li>สมาชิกทั้งหมด</li>
                                  </a>
                                  <a href="new_inbox.php">
                                      <li>Inbox พูดคุยกับทีมงาน</li>
                                  </a>
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>             
                <div class="menu">
                	<a href="#">PRODUCTS</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                  <a href="product.php" target="_blank">
                                      <li>All Products</li>
                                  </a>
                                  <a href="new_color.php">
                                  <li>Color</li>
                                  </a>
                              <a href="category.php">
                                      <li>Category</li>
                                  </a>
                              <a href="new_model.php">
                                      <li>ภาพนางแบบ</li>
                                  </a> 
                              <a href="new_supplier.php">
                                      <li>Supplier</li>
                                  </a>
                              <a href="new_about.php?txt_tb=deliveryproduct">
                                      <li>Delivery Detail</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=return">
                                      <li>Return & Exchanges Detail</li>
                                  </a>
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>
                <div class="menu">
                	<a href="#">REPORT</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                  <a href="report_properpieces.php">
                                      <li>สรุปยอดสินค้าที่ขายไป</li>
                                  </a>
                                  <a href="report_transport.php" target="_blank">
                                      <li>สรุปรายการส่งสินค้า</li>
                                  </a>
                                  <a href="new_user_order.php" target="_blank">
                                      <li>สมาชิกที่มียอดสั่งซื้อมากที่สุด</li>
                                  </a>
                                    <a href="report_stock_in.php" target="_blank">
                                      <li>สรุปรายการสิ้นค้าเข้า</li>
                                  </a>
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>   
                    
                              
                <div class="menu">
                	<a href="#">SELL PROMOTION</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                 <a href="product_hit.php">
                                      <li>ความ Hit ของสินค้า</li>
                                  </a>
                                  <a href="new_promotion.php">
                                      <li>Promotion CODE</li></a>
                                  <a href="new_arrival.php">
                                      <li>New Arrival</li>
                                  </a>
                                  <a href="best.php" target="_blank">
                                      <li>Best Seller</li>
                                  </a>     
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>
                <div class="menu">
                	<a href="#">ALL BANNER</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                  <a href="new_banner.php">
                                      <li>Header banner</li>
                                  </a>
                                  <a href="home_banner.php?txt_tb=Promotion">
                                      <li>Promotion banner</li>
                                  </a>
                                  <a href="home_banner.php?txt_tb=Arrivals">
                                      <li>New Arrivals banner</li>
                                  </a>
                                  <a href="home_banner.php?txt_tb=Discount">
                                      <li>Discount banner</li>
                                  </a>
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>
                <div class="menu">
                	<a href="#">HEADER MENU</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        
                        	<ul>
                                 <a href="new_about.php?txt_tb=Howto">
                                      <li>How to order</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=Payment">
                                      <li>Payment & Delivery</li>
                                  </a>
                                  <a href="new_bank.php">
                                      <li>ธนาคาร</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=Delivery">
                                      <li>Info > Delivery</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=Banking">
                                      <li>Info > Banking Info</li>
                                  </a>
                                  <a href="new_fashionblog.php">
                                      <li>Fashion blog</li>
                                  </a>
                                  <a href="new_webboard.php">
                                      <li>อัพเดทแจ้งเลขพัสดุ (เว็บบอร์ด)</li>
                                  </a>
                            </ul>
                        </div>
                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div> 
                <div class="menu">
                	<a href="#">FOOTER MENU</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                                 <a href="new_about.php?txt_tb=qa">
                                      <li>คำถามที่พบบ่อย</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=event">
                                      <li>กิจกรรมส่วนลด สมาชิก</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=Press">
                                      <li>สื่อประชาสัมพันธ์</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=condition">
                                      <li>เงื่อนไขและข้อตกลง</li>
                                  </a>
                                  <a href="new_about.php?txt_tb=careers">
                                      <li>ร่วมงานกับเรา</li>
                                  </a>
                                  
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div> 
                <div class="menu">
                	<a href="#">ADMIN</a></div>
                	<div class="block_style1">
                        <div class="block_style1_top">
                            <div class="block_style1_top-l"></div>
                            <div class="block_style1_top-r"></div>
                        </div>
                        <div class="block_style1-content">
                        	<ul>
                              <?php if ($_SESSION['AUTH_PERMISSION_TYPE'] == 1) {?>
                              <a href="new_user_login.php">
                                      <li>ผู้ใช้งาน</li>
                                  </a>
                              <a href="admin_change.php">
                                      <li>เปลี่ยนรหัสผ่าน</li>
                                  </a>
                              <?php }?>
                              <a href="logout.php">
                                      <li>ออกจากระบบ</li>
                                  </a>
                            </ul>
                        </div>

                        <div class="block_style1_bottom">
                            <div class="block_style1_bottom-l"></div>
                            <div class="block_style1_bottom-r"></div>
                        </div>                 	
                    </div>           
            </div>
            