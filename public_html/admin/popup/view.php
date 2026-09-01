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
	$sql ="SELECT * FROM popup WHERE pop_uid={$filtered_id}";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);

	$update_link ='<a href="update.php?id='.$_GET['id'].'" class="btn_1 size_n">수정</a>';
	$delete_link ='
		<input type="hidden" name="pop_uid" value="'.$_GET['id'].'" />
		<input type="submit" value="삭제" class="btn_3 size_n" />
	';
}

//이전글 다음글
$pageID = $row['pop_uid'];
$sql_lf="SELECT * FROM popup WHERE pop_uid = (select max(pop_uid) from popup where pop_uid < '$pageID' limit 1)";
$sql_rt="SELECT * FROM popup WHERE pop_uid = (select min(pop_uid) from popup where pop_uid > '$pageID' limit 1)";
$lf_result = mysqli_query($conn, $sql_lf);
$rt_result = mysqli_query($conn, $sql_rt);
$lf_row = mysqli_fetch_array($lf_result);
$rt_row = mysqli_fetch_array($rt_result);

$row['pop_regdate'] = mb_substr($row['pop_regdate'], 0, 10); //제목 글자수 css 사용해도 됨
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
				<table summary="팝업 관리 상세보기로 팝업 제목, 노출 기간, 노출 여부, 팝업 위치, 팝업 크기, 팝업 내용을 제공합니다.">
					<caption>팝업 관리 상세보기</caption>
					<colgroup>
						<col width="13%" />
						<col width="37%" />
						<col width="13%" />
						<col width="37%" />
					</colgroup>
					<tbody>
						<tr>
							<th colspan="4" scope="col" class="subject">
								<strong><?=$row['pop_title']?></strong>
								<div class="sub_info"><span><?=$row['pop_regdate']?></span></div>
							</th>
						</tr>
						<tr>
							<th scope="row">노출 기간</th>
							<td><?=$row['pop_start']?> ~ <?=$row['pop_end']?></td>
							<th scope="row">노출 여부</th>
							<td><?=$row['pop_view']?></td>
						</tr>
						<tr>
							<th scope="row">팝업 위치</th>
							<td>상단 : <?=$row['pop_top']?>px 왼쪽 : <?=$row['pop_left']?>px</td>
							<th scope="row">팝업 크기</th>
							<td><?=$row['pop_width']?>px</td>
						</tr>
						<tr>
							<td colspan="4" class="body_matter">
								<?if($row['pop_file0']){?>
								<img src="uploads/<?=$row['pop_file0']?>">
								<?}?>
							</td>
						</tr>
						<?if($rt_row['pop_uid']){?>
						<tr>
							<th scope="row" class="next"><span>다음글</span></th>
							<td class="ellips" colspan="3"><a href="view.php?id=<?=$rt_row['pop_uid']?>"><?=$rt_row['pop_title']?></a></td>
						</tr>
						<?}else{?>
						<?}?>
						<?if($lf_row['pop_uid']){?>
						<tr>
							<th scope="row" class="prev"><span>이전글</span></th>
							<td class="ellips" colspan="3"><a href="view.php?id=<?=$lf_row['pop_uid']?>"><?=$lf_row['pop_title']?></a></td>
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
