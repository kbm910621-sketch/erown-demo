<?php
$pageName = basename($_SERVER['PHP_SELF']); //페이지이름
$dirPage = strtolower(dirname($_SERVER['PHP_SELF'])); //폴더이름

if(strstr($pageName,"main")){
    $path_st = "none";
    $path_current = "관리자 메인";
}else if(strstr($pageName,"pw_change")){
    $path_st = "block";
    $path_parents = "기본 설정";
    $path_current = "비밀번호 변경";
}else if(strstr($pageName,"title_change")){
    $path_st = "block";
    $path_parents = "기본 설정";
    $path_current = "타이틀 관리";
}else if(strstr($pageName,"keyword_change")){
    $path_st = "block";
    $path_parents = "기본 설정";
    $path_current = "키워드 관리";
}else if(strstr($pageName,"gnb_change")){
    $path_st = "block";
    $path_parents = "기본 설정";
    $path_current = "메뉴 관리";    
}else if(strstr($dirPage,"notice")){
    $path_st = "block";
    $path_parents = "게시판 관리";
    $path_current = "공지사항";
}else if(strstr($dirPage,"gallery")){
    $path_st = "block";
    $path_parents = "게시판 관리";
    $path_current = "갤러리";
}else if(strstr($dirPage,"event")){
    $path_st = "block";
    $path_parents = "게시판 관리";
    $path_current = "이벤트";
}else if(strstr($dirPage,"faq")){
    $path_st = "block";
    $path_parents = "게시판 관리";
    $path_current = "자주묻는 질문";
}else if(strstr($dirPage,"user")){
    $path_st = "block";
    $path_parents = "게시판 관리";
    $path_current = "사용자 게시판";
}else if(strstr($dirPage,"estmate")){
    $path_st = "none";
    $path_current = "신청정보 관리";
}else if(strstr($dirPage,"popup")){
    $path_st = "none";
    $path_current = "팝업 관리";
}
?>

<div class="title">
    <h3><?=$path_current?></h3>
    <div class="path">
        <span class="path_home">홈</span>
        <span style="display:<?=$path_st?>"><?=$path_parents?></span>
        <span class="path_cnt"><?=$path_current?></span>
    </div>
</div>
