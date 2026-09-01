<?php
$pageName = basename($_SERVER['PHP_SELF']); //페이지이름
$dirPage = strtolower(dirname($_SERVER['PHP_SELF'])); //폴더이름

if(strstr($dirPage,"setting")){
    $menu_st[0] = "fix";
    $depth1_on[0] = "on";
    if(strstr($pageName,"pw_change")){
        $depth2_on[0] = "on";
    } else if(strstr($pageName,"title_change")){
        $depth2_on[1] = "on";
    } else if(strstr($pageName,"keyword_change")){
        $depth2_on[2] = "on";
    } else if(strstr($pageName,"gnb_change")){
        $depth2_on[3] = "on";
    }
}else if(strstr($dirPage,"bbs")){
    $menu_st[1] = "fix";
    $depth1_on[1] = "on";
    if(strstr($dirPage,"notice")){
        $depth2_on[2] = "on";
    } else if(strstr($dirPage,"gallery")){
        $depth2_on[3] = "on";
    } else if(strstr($dirPage,"event")){
        $depth2_on[4] = "on";
    } else if(strstr($dirPage,"faq")){
        $depth2_on[5] = "on";
    } else if(strstr($dirPage,"user")){
        $depth2_on[6] = "on";
    }
}else if(strstr($dirPage,"estmate")){
    $depth1_on[2] = "on";
}else if(strstr($dirPage,"popup")){
    $depth1_on[3] = "on";
}
?>

<header id="header">
    <h1><a href="/admin/main.php">가온엔</a></h1>
    <div class="user">
        <div class="user_id"><a href="/admin/setting/pw_change.php"><span><?=$_SESSION['MID']?></span></a></div>
        <span class="logout"><a href="/admin/logout.php" title="로그아웃">로그아웃</a></span>
    </div>
    <nav class="gnb">
        <ul>
        <li class="depth_1 accordion <?=$depth1_on[0]?>">
        	<a href="#;">기본 설정</a>
        	<ul class="depth_2 <?=$menu_st[0]?>">
        		<li class="<?=$depth2_on[0]?>"><a href="/admin/setting/pw_change.php">비밀번호 변경</a></li>
        		<li class="<?=$depth2_on[1]?>"><a href="/admin/setting/title_change.php">타이틀 관리</a></li>
                <li class="<?=$depth2_on[2]?>"><a href="/admin/setting/keyword_change.php">키워드 관리</a></li>
        	</ul>
        </li>
        <li class="depth_1 accordion <?=$depth1_on[1]?>">
        	<a href="#;">포트폴리오 관리</a>
        	<ul class="depth_2 <?=$menu_st[1]?>">
        		<li class="<?=$depth2_on[2]?>"><a href="/admin/bbs/portfolio/admin_portfolio.php">포트폴리오</a></li>
        	</ul>
        </li>
        <li class="depth_1"><a href="/admin/estmate/list.php">신청정보 관리</a></li>
        <li class="depth_1 <?=$depth1_on[3]?>"><a href="/admin/popup/list.php">팝업 관리</a></li>
        </ul>
    </nav>
</header>

<script>
//accordion
$(".accordion").click(function(e){
    //e.preventDefault();
    if($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).find("ul").slideUp(100);
    } else {
        $(".accordion").removeClass('active');
        $(this).addClass('active');
        $(".accordion > ul").parent().not(this).find("ul").slideUp(100);
        $(this).find("ul").slideToggle(100);
    }
});
</script>
