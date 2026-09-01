<div id="lnb" class="<?=$use_depth?>">
    <!--inner-->
    <div class="inner">
        <div class="home">
            <a href="/geboard/index.php">home</a>
        </div>
        <div class="drop_nav depth1 <?=$use_depth?>">
            <strong class="current">
                <?=$path_current?>
                <span class="plus"><a href="#;">더보기</a></span>
            </strong>
            <ul>
                <?php
            	$i = 1;
            	while($i<=$main_cnt)
            	{
                    $gnb_on = ${'gnb_on_'.$i};
                    $gnb_name = ${'name_gnb_'.$i};
                    $gnb_link = ${'gnb_folder_'.$i};
                ?>
            		<li class="<?=$gnb_on?>"><a href="<?=$gnb_link?>"><?=$gnb_name?></a></li>
                <?php $i++; }?>
                <li class="<?=$lnb_on_12?>"><a href="<?=$gnb_folder_12?>"><?=$name_gnb_12?></a></li>
            </ul>
        </div>
        <?php if(($depth2_on) == 1){?>
        <div class="drop_nav depth2 <?=$use_depth?>">
            <strong class="current">
                <?=$path_sub?>
                <span class="plus"><a href="#;">더보기</a></span>
            </strong>

            <!--sub-->
            <?php if(($gnb_on_1) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_1; $i++)
            	{
                    $sub_on = ${'sub_on_1'.$i};
                    $sub_name = ${'name_gnb_sub_1'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_1.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_2) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_2; $i++)
            	{
                    $sub_on = ${'sub_on_2'.$i};
                    $sub_name = ${'name_gnb_sub_2'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_2.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_3) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_3; $i++)
            	{
                    $sub_on = ${'sub_on_3'.$i};
                    $sub_name = ${'name_gnb_sub_3'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_3.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_4) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_4; $i++)
            	{
                    $sub_on = ${'sub_on_4'.$i};
                    $sub_name = ${'name_gnb_sub_4'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_4.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_5) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_5; $i++)
            	{
                    $sub_on = ${'sub_on_5'.$i};
                    $sub_name = ${'name_gnb_sub_5'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_5.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_6) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_6; $i++)
            	{
                    $sub_on = ${'sub_on_6'.$i};
                    $sub_name = ${'name_gnb_sub_6'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_6.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_7) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_7; $i++)
            	{
                    $sub_on = ${'sub_on_7'.$i};
                    $sub_name = ${'name_gnb_sub_7'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_7.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_8) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_8; $i++)
            	{
                    $sub_on = ${'sub_on_8'.$i};
                    $sub_name = ${'name_gnb_sub_8'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_8.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_9) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_9; $i++)
            	{
                    $sub_on = ${'sub_on_9'.$i};
                    $sub_name = ${'name_gnb_sub_9'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_9.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_10) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_10; $i++)
            	{
                    $sub_on = ${'sub_on_10'.$i};
                    $sub_name = ${'name_gnb_sub_10'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_10.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_11) == 'on'){?>
            <ul>
                <?php
                for($i=1; $i<=$sub_cnt_11; $i++)
            	{
                    $sub_on = ${'sub_on_11'.$i};
                    $sub_name = ${'name_gnb_sub_11'.$i};
                    $link_end = '.php';
                    $sub_link = $sub_folder_11.$i.$link_end;
                ?>
                    <li class="<?=$sub_on?>"><a href="<?=$sub_link?>"><?=$sub_name?></a></li>
                <?php }?>
            </ul>
            <?}?>

            <!--sub-->
            <?php if(($gnb_on_12) == 'on'){?>
            <ul>

                <li class="<?=$sub_on_bd5?>"><a href="<?=$bbs_folder_5?>"><?=$name_gnb_subl_5?></a></li>
            </ul>
            <?}?>

        </div>
        <?}?>
    </div>
    <!--//inner-->
</div>
