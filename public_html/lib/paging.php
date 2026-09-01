<!--paging-->
<div class="paging">
<?php
//$totals
//$view_limit
$PHP_SELF = '';
$rr = ceil($totals/$view_limit);

// echo $_page;
// echo $page;
// echo $rr;
// echo $totals;


//이전 페이지 구하기
$before = $_page-1; //현재 페이지수 에서 -1을 준다.
if($before<1)($before=1);

//다음 페이지 구하기
$next = $_page+1;
if($next>$rr)($next=$rr);

//그룹페이지 구성//
//처음
if($_page%10){$goto =$_page - $_page%10+1; //한 그룹당 10개 페이지를 지정 '10'을 넘기면 1을 증가.
}else if($goto = $_page -9); // '10'배수가 아니면 -'9'

//끝
$last = $goto + 10; //예) $goto='1'이라면 $last='11'이 되어야 합니다.

//이전페이지 그룹 출력
$before_group = $goto -1;
if($before_group < 1)($before_group = 1);
if($_page !=1) echo ("<a href='$PHP_SELF?_page=$before_group' class='boxPrev'>이전 페이지 이동</a>"); //이전 페이지 그룹출력

//페이지 번호 출력
for($e=$goto; $e<$last; $e++){ //현재페이지가 전체페이지 보다 작으면 페이지를 증가
    if($e>$rr) break; //총 나타날 페이지 번호 보다 크면 멈추고 다음을 실행
    if($e==$_page) echo ("<a href='$PHP_SELF?_page=$e' class='boxnow'>$e</a>"); //$e 와 $_page번호가 서로 같으면
    else {
        echo ("<a href='$PHP_SELF?_page=$e'>$e</a>"); //$e와 $_page번호가 서로 같지 않으면
    }
}

//다음페이지 그룹 출력
$next_group = $last;
if($next_group > $rr)($next_group = $rr); //$next_group는 $rr보다 크면 $rr은 $next_group가 된다.
if($_page != $rr && $totals != 0) echo ("<a href='$PHP_SELF?_page=$next_group' class='boxNext'>다음 페이지 이동</a>"); //다음페이지
?>
</div>
<!--//paging-->


<!--paging-->
<!-- <div class="paging" id="">
  <a href='#;' class="boxFirst" title="처음 페이지 이동">처음 페이지 이동<span></span></a><a href='#;' class="boxPrev" title="이전 페이지 이동">이전 페이지 이동</a><a href='#;' class="boxnow">1</a><a href='#;'>2</a><a href='#;'>3</a><a href='#;'>4</a><a href='#;'>5</a><a href='#;' class="boxNext" title="다음 페이지 이동">다음 페이지 이동</a><a href='#;' class="boxLast" title="마지막 페이지 이동">마지막 페이지 이동<span></span></a>
</div> -->
<!--//paging-->
