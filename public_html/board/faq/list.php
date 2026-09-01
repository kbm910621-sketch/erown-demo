<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";?>
<?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";?>

<?include_once $_SERVER['DOCUMENT_ROOT'] . "/inc/head.php";?>

<?php
//검색
$frFIELD = $_GET['frFIELD'];
$frSearch = $_GET['frSearch'];
$sub_SQL="";
if($frFIELD && $frSearch){
  if($frFIELD=="qn_all"){
    $sub_SQL = "WHERE qn_title LIKE '%$frSearch%' or qn_description LIKE '%$frSearch%'";
  }else{
    $sub_SQL = "WHERE $frFIELD LIKE '%$frSearch%' ";
  }
}

$_page=$_GET['_page'];
$view_limit = 10; //게시글 노출 수
if(!$_page)($_page=1);
$page = ($_page-1)*$view_limit;

$sql = "SELECT COUNT(*) FROM qna $sub_SQL";
$result = mysqli_query($conn, $sql);
$temp = mysqli_fetch_array($result);
$totals = $temp[0];
?>

<script type="text/javascript">
  //글검색
  $(function(){
    $('#btnSearch').click(function(){
      searchList();
    });
  });

  var searchList = function(){
    //if(!chkForm('frSearch', '검색어를', 'input', '1')) return;
    var frSearch = $('#frSearch').val();
    location.href="list.php?frFIELD="+$('#frFIELD option:selected').val()+"&frSearch="+encodeURI(frSearch);
  }

  var EnterKey = function(){
    if(event.keyCode == 13)
    {
      searchList();
    }
  }
</script>

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
            <!--search-->
            <div class="search_box">
                <fieldset>
                    <legend>게시물검색</legend>
                    <div class="single">
                        <select name="frFIELD" id="frFIELD" class="select_type01" title="검색조건 선택">
                            <option value='qn_all' <?if($frFIELD=='qn_all'){?>selected<?}?>>전체</option>
                            <option value='qn_title' <?if($frFIELD=='qn_title'){?>selected<?}?>>제목</option>
                            <option value='qn_description' <?if($frFIELD=='qn_description'){?>selected<?}?>>내용</option>
                        </select>
                        <input type="text" class="input_type01 w_400" name="frSearch" id="frSearch" value="<?=$frSearch?>" title="검색어 입력"  placeholder="검색어를 입력하세요" onkeypress="EnterKey();">
                        <span class="search_btn" id="btnSearch">검색</span>
                    </div>
                </fieldset>
            </div>
            <!--//search-->
            <!--board_A0_list-->
            <div class="board_A0_F">
                <p class="count">총 <b><?=$totals?></b>건</p>
                <!--accordion-->
                <div class="accordion">
                <?php
                if(($totals) > 0){
                    $sql = "SELECT * FROM qna $sub_SQL ORDER BY qn_uid DESC LIMIT $page, $view_limit";
                    //SELECT * FROM 테이블이름 WHERE 조건 ORDER BY 컬럼이름 LIMIT 갯수
                    //echo mysqli_error($sql);
                    $result = mysqli_query($conn, $sql);
                    $cnt = $page+1; //게시글 번호
                    while($row = mysqli_fetch_array($result)){
                ?>
                <dl>
                    <dt><?=$row['qn_title']?><i></i></dt>
                    <dd><?=nl2br($row['qn_description'])?></dd>
                </dl>
                <?$cnt++;}}?>
                <?if(($totals) <= 0){?>
                    <div class="no_text">등록된 글이 없습니다.</div>
                <?}?>
                </div>
                <!--//accordion-->
            </div>
            <!--//board_A0_faq-->
            <script>
            //accordion
            $(".accordion > dl").click(function(e){
                e.preventDefault();
                if($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $(this).find("dd").slideUp(100);
                    $(".accordion i").removeClass('on');
                } else {
                    $(".accordion > dl").removeClass('active');
                    $(".accordion i").removeClass('on');
                    $(this).find("i").addClass('on');
                    $(this).addClass('active');
                    $(".accordion > dl > dd").parent().not(this).find("dd").slideUp(100);
                    $(this).find("dd").slideToggle(100);
                }
            });
            </script>
            <?include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/paging.php";?>
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
