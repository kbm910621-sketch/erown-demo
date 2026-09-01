<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";?>

<?php
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //필터 보안
	$sql ="SELECT * FROM photo WHERE ph_uid={$filtered_id}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
}

//이전글 다음글
$pageID = $row['ph_uid'];
$sql_lf="SELECT * FROM photo WHERE ph_uid = (select max(ph_uid) from photo where ph_uid < '$pageID' limit 1)";
$sql_rt="SELECT * FROM photo WHERE ph_uid = (select min(ph_uid) from photo where ph_uid > '$pageID' limit 1)";
$lf_result = mysqli_query($conn, $sql_lf);
$rt_result = mysqli_query($conn, $sql_rt);
$lf_row = mysqli_fetch_array($lf_result);
$rt_row = mysqli_fetch_array($rt_result);

//조회수 증가
$no = $_GET['id'];
if($no != $_COOKIE['hit_notice'.$no]){
	$sql = "UPDATE photo SET ph_hit=ph_hit+1 WHERE ph_uid='$no'"; //쿼리전송
	$result = mysqli_query($conn, $sql);
	// setcookie('hit_notice'.$no,$no,time()+60*60*24,'/');
}
$row['ph_regdate'] = mb_substr($row['ph_regdate'], 0, 10); //제목 글자수 css 사용해도 됨
?>

<body>

<!--blank_layer-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/blank.php";?>
<!--//blank_layer-->
<!--skip-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/skip.php";?>
<!--//skip-->

<!--wrap-->
<div id="wrap">

	<!--header-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/header.php";?>
    <!--//header-->
	<!--visual-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/visual.php";?>
    <!--//visual-->
	<!--lnb-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/lnb.php";?>
    <!--//lnb-->

	<!--container-->
	<div id="container">
		<!--inner-->
		<div class="inner">

			<!--title-->
            <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/title.php";?>
    		<!--//title-->
			<!--content-->
			<section class="content">
				<!--board_A0_view-->
				<div class="board_A0_V">
					<table summary="갤러리입니다">
	                    <caption>갤러리</caption>
						<colgroup>
							<col width="10%" />
							<col width="90%" />
						</colgroup>
						<tbody>
							<tr>
								<th colspan="2" scope="col" class="subject">
									<strong><?=$row['ph_title']?></strong>
									<div class="sub_info">
										<span><?=$row['ph_regdate']?></span>
										<span>조회 : <?=$row['ph_hit']?></span>
									</div>
								</th>
							</tr>
							<tr>
								<td colspan="2" class="body_matter">
									<?if($row['ph_file0']){?>
									<img src="/admin/bbs/gallery/uploads/<?=$row['ph_file0']?>">
									<?}if($row['ph_file1']){?>
									<img src="/admin/bbs/gallery/uploads/<?=$row['ph_file1']?>">
									<?}if($row['ph_file2']){?>
									<img src="/admin/bbs/gallery/uploads/<?=$row['ph_file2']?>">
									<?}if($row['ph_file3']){?>
									<img src="/admin/bbs/gallery/uploads/<?=$row['ph_file3']?>">
									<?}if($row['ph_file4']){?>
									<img src="/admin/bbs/gallery/uploads/<?=$row['ph_file4']?>">
									<?}?>
									<?=$row['ph_description']?>
								</td>
							</tr>
							<?if($rt_row['ph_uid']){?>
							<tr>
								<th scope="row" class="next"><span>다음글</span></th>
								<td class="ellips"><a href="view.php?id=<?=$rt_row['ph_uid']?>"><?=$rt_row['ph_title']?></a></td>
							</tr>
							<?}else{?>
							<?}?>
							<?if($lf_row['ph_uid']){?>
							<tr>
								<th scope="row" class="prev"><span>이전글</span></th>
								<td class="ellips"><a href="view.php?id=<?=$lf_row['ph_uid']?>"><?=$lf_row['ph_title']?></a></td>
							</tr>
							<?}else{?>
							<?}?>
						</tbody>
					</table>
				</div>
				<!--//board_A0_view-->
				<!--button-->
				<div class="button a_r mat_30">
					<input type="button" class="btn_2 size_n" value="목록" onClick="location.href='list.php'">
				</div>
				<!--//button-->
			</section>
            <!--//content-->

        </div>
        <!--//inner-->
    </div>
    <!--//container-->

    <!--footer-->
    <?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/footer.php";?>
    <!--//footer-->

</div>
<!--//wrap-->

</body>
</html>
