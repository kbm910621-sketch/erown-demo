<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<?php
if(isset($_GET['id'])){
	$filtered_id = mysqli_real_escape_string($conn, $_GET['id']); //필터 보안
	$sql ="SELECT * FROM event WHERE ev_uid={$filtered_id}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);

	$update_link ='<a href="update.php?id='.$_GET['id'].'" class="btn_1 size_n">수정</a>';
	$delete_link ='
		<input type="hidden" name="ev_uid" value="'.$_GET['id'].'" />
		<input type="submit" value="삭제" class="btn_3 size_n" />
	';
}

//이전글 다음글
$pageID = $row['ev_uid'];
$sql_lf="SELECT * FROM event WHERE ev_uid = (select max(ev_uid) from event where ev_uid < '$pageID' limit 1)";
$sql_rt="SELECT * FROM event WHERE ev_uid = (select min(ev_uid) from event where ev_uid > '$pageID' limit 1)";
$lf_result = mysqli_query($conn, $sql_lf);
$rt_result = mysqli_query($conn, $sql_rt);
$lf_row = mysqli_fetch_array($lf_result);
$rt_row = mysqli_fetch_array($rt_result);

//조회수 증가
$no = $_GET['id'];
if($no != $_COOKIE['hit_notice'.$no]){
	$sql = "UPDATE event SET ev_hit=ev_hit+1 WHERE ev_uid='$no'"; //쿼리전송
	$result = mysqli_query($conn, $sql);
	// setcookie('hit_notice'.$no,$no,time()+60*60*24,'/');
}
$row['ev_regdate'] = mb_substr($row['ev_regdate'], 0, 10); //제목 글자수 css 사용해도 됨
?>

<!--wrap-->
<div id="wrap">
	<!--container-->
	<div id="container">
		<!--title-->
		<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php";?>
		<!--//title-->

		<!--content-->
		<section class="content">

			<!--board_A0_view-->
			<div class="board_A0_V">
				<table summary="이벤트 게시판">
                    <caption>이벤트</caption>
					<colgroup>
						<col width="10%" />
						<col width="90%" />
					</colgroup>
					<tbody>
						<tr>
							<th colspan="2" scope="col" class="subject">
								<strong><?=$row['ev_title']?></strong>
								<div class="sub_info">
									<span><?=$row['ev_regdate']?></span>
									<span>조회 : <?=$row['ev_hit']?></span>
								</div>
							</th>
						</tr>
						<tr>
							<td colspan="2" class="body_matter">
								<?if($row['ev_file1']){?>
								<img src="uploads/<?=$row['ev_file1']?>">
								<?}?>
								<?=$row['ev_description']?>
							</td>
						</tr>
						<?if($rt_row['ev_uid']){?>
						<tr>
							<th scope="row" class="next"><span>다음글</span></th>
							<td class="ellips"><a href="view.php?id=<?=$rt_row['ev_uid']?>"><?=$rt_row['ev_title']?></a></td>
						</tr>
						<?}else{?>
						<?}?>
						<?if($lf_row['ev_uid']){?>
						<tr>
							<th scope="row" class="prev"><span>이전글</span></th>
							<td class="ellips"><a href="view.php?id=<?=$lf_row['ev_uid']?>"><?=$lf_row['ev_title']?></a></td>
						</tr>
						<?}else{?>
						<?}?>
					</tbody>
				</table>
			</div>
			<!--//board_A0_view-->
			<!--button-->
			<div class="button a_r mat_30">
			<form action="process_delete.php" method="post" onsubmit="if(!confirm('글을 삭제할까요?')){return false;}">
				<?=$delete_link?>
				<?=$update_link?>
				<input type="button" class="btn_2 size_n" value="목록" onClick="location.href='list.php'">
			</form>
			</div>
			<!--//button-->

		</section>
		<!--//content-->
	</div>
	<!--//container-->
</div>
<!--//wrap-->

</body>
</html>
