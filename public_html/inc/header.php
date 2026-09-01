<header id="header" class="<?php echo $use_depth?>">
    <!--inner-->
    <div class="inner">
        <h1 class="logo"><a href="/index.php">사이트로고</a></h1>
        <div class="mobile_hamburger">
            <button class="gnb_open"><span class="stic_1"></span><span class="stic_2"></span><span class="stic_3"></span></button>
        </div>
        <!--gnb-->
        <nav id="gnb">
            <!--main_menu-->
            <div class="main_menu">
                <ul>
                    
                    <?php
                	$i = 1;
                	while($i<=$main_cnt)
                	{

                        $gnb_on = ${'gnb_on_'.$i};
                        $gnb_name = ${'name_gnb_'.$i};
                        $link_first = ${'gnb_folder_'.$i};
                        $link_end = '.php';
                        $gnb_link = $link_first.$link_end;
                        $gnb_sub_cnt = ${'sub_cnt_'.$i};
                    ?>
                        <li class="depth1 <?php echo $gnb_on?>">
                            <a href="<?php echo $gnb_link?>"><?php echo $gnb_name?><span class="gnb-sub">Reference</span></a>
                        </li>
                    <?php $i++; }?>
                    <li class="depth1 <?php echo $gnb_on_12?>">
                        <a href="/board/estmate/write.php">상담신청<span class="gnb-sub">Contact</span></a>
                    </li>
                </ul>
                <div class="gnb-contact">
                    <div class="gnb-contact-lbl">Contact</div>
                    <div class="gnb-contact-tel">062-000-0000</div>
                    <div class="gnb-contact-email">lgmo123@naver.com</div>
                </div>
            </div>
            <!--//main_menu-->
        </nav>
        <!--//gnb-->
    </div>
    <!--//inner-->
    <div class="gnb_bar"></div>
</header>
