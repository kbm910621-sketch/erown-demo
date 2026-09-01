<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/session_chk.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/head.php";?>

<body class="bg_body">

<!--header-->
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php";?>
<!--//header-->

<!--wrap-->
<div id="wrap">
	<!--container-->
	<div id="container">
		<!--title-->
		<?include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/title.php";?>
		<!--//title-->

		<!--content-->
		<section class="content">

			<!--board_A0_list-->
	  		<div class="board_A0_L">
				<h2 class="bbs_rctit">공지사항 최근글</h2>
				<table summary="공지사항 목록이며 번호, 제목, 작성자, 작성일을 제공하고 제목 링크를 통해 상세페이지로 이동합니다.">
					<caption>공지사항 최근글 목록</caption>
					<colgroup>
						<col width="100" />
						<col width="*" />
						<col width="100" />
						<col width="200" />
						<col width="100" />
					</colgroup>
					<thead>
						<tr>
							<th scope="col" class="resp">번호</th>
							<th scope="col">제목</th>
							<th scope="col" class="resp">작성자</th>
							<th scope="col">작성일</th>
							<th scope="col" class="resp">조회수</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$view_limit = 5; //게시글 노출 수

						$sql = "SELECT COUNT(*) FROM notice";
						$result = mysqli_query($conn, $sql);
						$temp = mysqli_fetch_array($result);
						$totals = $temp[0];

						if(($totals) > 0){
							$sql = "SELECT * FROM notice ORDER BY notice_uid DESC LIMIT $view_limit";
							//SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
							$result = mysqli_query($conn, $sql);
							$cnt = $page+1; //게시글 번호
							while($row = mysqli_fetch_array($result)){
								$notice_title_min=$row['notice_title'];
								if(mb_strlen($notice_title_min)>30) {
									$notice_title_min=str_replace($row['notice_title'],mb_substr($row['notice_title'],0,30,"utf-8")."...",$row['notice_title']); //title이 30을 넘어서면 ...표시
								}
								$row['notice_regdate'] = mb_substr($row['notice_regdate'], 0, 10);

								//새글 표시
                                $new_date = $row['notice_regdate'];
                                $now_date = date('Y-m-d', time());
						?>
						<tr>
							<td class="resp"><?=$cnt?></td>
							<td class="subject">
								<?if ($new_date == $now_date){?>
                                <i class="icon_new"></i>
                                <?}?>
								<a href="/admin/bbs/notice/view.php?id=<?=$row['notice_uid']?>"><?=$notice_title_min?></a>
							</td>
							<td class="resp"><?=$row['notice_author']?></td>
							<td><?=$row['notice_regdate']?></td>
							<td><?=$row['notice_hit']?></td>
						</tr>
        				<?$cnt++;}}?>
						<?if(($totals) <= 0){?>
						<tr>
							<td colspan="5" class="no_text">등록된 글이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</div>
			<!--//board_A0_list-->

			<!--board_A0_list-->
	  		<div class="board_A0_L mat_50">
				<h2 class="bbs_rctit">신청정보 최근글</h2>
				<table summary="신청정보 최근글 목록">
					<caption>신청정보 최근글 목록</caption>
					<colgroup>
						<col width="100" />
						<col width="" />
						<col width="" />
						<col width="" />
						<col width="200" />
					</colgroup>
					<thead>
						<tr>
							<th scope="col" class="resp">번호</th>
							<th scope="col" class="resp">이름</th>
							<th scope="col" class="resp">성별</th>
							<th scope="col" class="resp">종류</th>
							<th scope="col">작성일</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$view_limit = 5; //게시글 노출 수

						$sql = "SELECT COUNT(*) FROM estmate";
						$result = mysqli_query($conn, $sql);
						$temp = mysqli_fetch_array($result);
						$totals = $temp[0];

						if(($totals) > 0){
							$sql = "SELECT * FROM estmate ORDER BY est_uid DESC LIMIT $view_limit";
							//SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
							$result = mysqli_query($conn, $sql);
							$cnt = $page+1; //게시글 번호
							while($row = mysqli_fetch_array($result)){

								$est_title_min=$row['est_name'];
								if(mb_strlen($est_title_min)>30) {
									$est_title_min=str_replace($row['est_name'],mb_substr($row['est_name'],0,30,"utf-8")."...",$row['est_name']); //title이 30을 넘어서면 ...표시
								}
								$row['est_regdate'] = mb_substr($row['est_regdate'], 0, 10);
						?>
						<tr>
							<td class="resp"><?=$cnt?></td>
							<td class="resp"><a href="/admin/estmate/view.php?id=<?=$row['est_uid']?>"><?=$est_title_min?></a></td>
							<td class="resp"><?=$row['est_gender']?></td>
							<td class="resp"><?=$row['est_type']?></td>
							<td><?=$row['est_regdate']?></td>
						</tr>
        				<?$cnt++;}}?>
						<?if(($totals) <= 0){?>
						<tr>
							<td colspan="4" class="no_text">등록된 글이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</div>
			<!--//board_A0_list-->

			<!--board_A0_gallery-->
      		<div class="board_A0_G mat_50">
        		<h2 class="bbs_rctit">갤러리 최근글</h2>
        		<ul>
					<?php
					$view_limit = 4; //게시글 노출 수

					$sql = "SELECT COUNT(*) FROM photo";
					$result = mysqli_query($conn, $sql);
					$temp = mysqli_fetch_array($result);
					$totals = $temp[0];

					if(($totals) > 0){
						$sql = "SELECT * FROM photo ORDER BY ph_uid DESC LIMIT $view_limit";
						$result = mysqli_query($conn, $sql);
						$cnt = $page+1; //게시글 번호
						while($row = mysqli_fetch_array($result)){
					?>

					<li>
						<a href="/admin/bbs/gallery/view.php?id=<?=$row['ph_uid']?>">
							<div style="background-image:url(/admin/bbs/gallery/uploads/<?=$row['ph_file0']?>);"><span class="icon_plus"></span></div>
							<strong><?=$row['ph_title']?></strong>
						</a>
					</li>
          			<?$cnt++;}}?>
					<?if(($totals) <= 0){?>
					<li class="no_text a_c">등록된 글이 없습니다.</li>
					<?}?>
		        </ul>
			</div>
			<!--//board_A0_gallery-->

			<!--board_A0_gallery-->
			<div class="board_A0_G mat_50">
        		<h2 class="bbs_rctit">이벤트 최근글</h2>
        		<ul>
					<?php
					$view_limit = 2; //게시글 노출 수

					$sql = "SELECT COUNT(*) FROM event";
					$result = mysqli_query($conn, $sql);
					$temp = mysqli_fetch_array($result);
					$totals = $temp[0];

					if(($totals) > 0){
						$sql = "SELECT * FROM event ORDER BY ev_uid DESC LIMIT $view_limit";
						//SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
						$result = mysqli_query($conn, $sql);
						$cnt = $page+1; //게시글 번호
						while($row = mysqli_fetch_array($result)){
							$row['ev_regdate'] = mb_substr($row['ev_regdate'], 0, 10);
					?>
					<li class="colum_2">
						<a href="/admin/bbs/event/view.php?id=<?=$row['ev_uid']?>">
							<div style="background-image:url(/admin/bbs/event/uploads/<?=$row['ev_file0']?>);"><span class="icon_plus"></span></div>
							<strong><?=$row['ev_title']?></strong>
							<span class="sub_txt"><?=$row['ev_regdate']?></span>
						</a>
					</li>
					<?$cnt++;}}?>
					<?if(($totals) <= 0){?>
					<li class="no_text a_c">등록된 글이 없습니다.</li>
					<?}?>
				</ul>
			</div>
			<!--//board_A0_gallery-->

		</section>
		<!--//content-->
	</div>
	<!--//container-->
</div>
<!--//wrap-->

</body>
</html>
