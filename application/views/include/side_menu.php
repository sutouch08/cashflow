

<!------------------------------------------   Side menu Start ---------------------------------------------->
	<ul class="nav nav-list">  
        <!--/*******************************************************************  กำหนดค่า  ********************************************************************/-->
        <li class="<?php echo active_menu(10,$id_menu); ?>"><a href="<?php echo valid_menu(10,"flow"); ?>"><i class="menu-icon fa fa-flash"></i><span class="menu-text">บันทึก Cash Flow</span></a></li>
        <li class="<?php echo isOpen(1, $id_menu); ?>"><a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-credit-card"></i><span class="menu-text">ตั๋วกู้ (PN/LC)</span><b class="arrow fa fa-angle-down"></b></a>
        	<ul class="submenu">
        		<li class="<?php echo active_menu(12,$id_menu); ?>"><a href="<?php echo valid_menu(12,"loan"); ?>"><i class="menu-icon fa fa-caret-right"></i>เปิดตั๋วกู้</a><b class="arrow"></b></li>
                <li class="<?php echo active_menu(13,$id_menu); ?>"><a href="<?php echo valid_menu(13,"repay"); ?>"><i class="menu-icon fa fa-caret-right"></i>จ่ายคืนตั๋วกู้</a><b class="arrow"></b></li>
        	</ul>
        </li>
		<li class="<?php echo isOpen(0, $id_menu); ?>"><a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-cogs"></i><span class="menu-text">กำหนดค่า</span><b class="arrow fa fa-angle-down"></b></a>
			<ul class="submenu">  <!-- Second Level Menu -->
            	<li class="<?php echo active_menu(1,$id_menu); ?>"><a href="<?php echo valid_menu(1,"bank"); ?>"><i class="menu-icon fa fa-caret-right"></i>เพิ่ม/แก้ไข ธนาคาร</a><b class="arrow"></b></li>	
                <li class="<?php echo active_menu(2,$id_menu); ?>"><a href="<?php echo valid_menu(2,"account"); ?>"><i class="menu-icon fa fa-caret-right"></i>เพิ่ม/แก้ไข บัญชีธนาคาร</a><b class="arrow"></b></li> 	
                <li class="<?php echo active_menu(3,$id_menu); ?>"><a href="<?php echo valid_menu(3,"employee"); ?>"><i class="menu-icon fa fa-caret-right"></i>เพิ่ม/แก้ไข พนักงาน</a><b class="arrow"></b></li> 	
                <li class="<?php echo active_menu(4,$id_menu); ?>"><a href="<?php echo valid_menu(4,"user"); ?>"><i class="menu-icon fa fa-caret-right"></i>เพิ่ม/แก้ไข ชื่อผู้ใช้งาน</a><b class="arrow"></b></li> 	
                	
                <li class="<?php echo active_menu(7,$id_menu); ?>"><a href="<?php echo valid_menu(7,"company"); ?>"><i class="menu-icon fa fa-caret-right"></i>เพิ่ม/แก้ไข บริษัท</a><b class="arrow"></b></li> 
                <li class="<?php echo active_menu(8,$id_menu); ?>"><a href="<?php echo valid_menu(8,"profile"); ?>"><i class="menu-icon fa fa-caret-right"></i>เพิ่ม/แก้ไข โปรไฟล์</a><b class="arrow"></b></li> 
                <li class="<?php echo active_menu(9,$id_menu); ?>"><a href="<?php echo valid_menu(9,"permit"); ?>"><i class="menu-icon fa fa-caret-right"></i>กำหนดสิทธิ์</a><b class="arrow"></b></li> 	
                <li class="<?php echo active_menu(11,$id_menu); ?>"><a href="<?php echo valid_menu(11,"permit_ac"); ?>"><i class="menu-icon fa fa-caret-right"></i>กำหนดสิทธิ์ สมุดบัญชี</a><b class="arrow"></b></li> 
			</ul>
		</li><!-- First Level -->
        <!--/*******************************************************************  จบ กำหนดค่า  ********************************************************************/-->
        
        <!--/*******************************************************************  รายงาน ********************************************************************/-->
        <li calss=""><a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-home"></i><span class="menu-text">รายงานต่างๆ</span><b class="arrow fa fa-angle-down"></b></a><!-- First Level -->
        	<ul class="submenu">
            	<li class=""><a href="<?php echo valid_menu(1,"#"); ?>"><i class="menu-icon fa fa-caret-right"></i>รายงาน1</a><b class="arrow"></b></li> 	
                <li class=""><a href="<?php echo valid_menu(1,"#"); ?>"><i class="menu-icon fa fa-caret-right"></i>รายงาน2</a><b class="arrow"></b></li> 	
            </ul>
         </li><!-- First Level -->
        <!--/*******************************************************************  จบรายงาน  ********************************************************************/-->
 
        <!-- **********************************  เก็บไว้เป็นตัวอย่าง ***********************************
		<li class=""><a href="#" class="dropdown-toggle"><i class="menu-icon fa fa-file-o"></i>
        	<span class="menu-text"> Other Pages 
            <!-- #section:basics/sidebar.layout.badge 
            	<span class="badge badge-primary">5</span></span> <b class="arrow fa fa-angle-down"></b></a>	<b class="arrow"></b>
			<ul class="submenu">
				<li class=""><a href="#"><i class="menu-icon fa fa-caret-right"></i>FAQ	</a><b class="arrow"></b></li>
				<li class="active"><a href="#"><i class="menu-icon fa fa-caret-right"></i>Blank Page</a></li>
			</ul>
		</li>
        ****************************************************************************************** -->
	</ul><!-- /.nav-list -->
    