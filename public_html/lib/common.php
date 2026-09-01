<?php
//#### 캐시삭제 ####/
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


//#### session유지 ####/
ini_set("session.use_trans_sid", 0);    // PHPSESSID를 form으로 자동으로 넘기는 버그 차단
ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 함께 붙어오는 경우 차단
@session_cache_limiter("no-cache");
/*
//#### php.ini에 지정된 기본값 사용 만약 특정 사이트의 경우 세션시간이나 캐쉬시간조절을 위해선
	하단 부분의 값을 변경하여서 사용.
ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.
*/
session_start();



//에러메세지 출력
function alert($msg){
    echo "
    <script>
    window.alert('$msg');
    history.back(1);
    </script>
    ";
    exit; //위에 에러 메세지만 뛰운다.
}




//문자열을 XSS 공격코드일 경우 처리하는 함수, 수동적으로 전달변수를 처리할 경우 작업
function chkXSS($str){
    if(function_exists("str_ireplace")){
        $str = str_ireplace("<script","<XSS_script",$str);
        $str = str_ireplace("</script","</XSS_script",$str);

        $str = str_ireplace("<style","<XSS_style",$str);
        $str = str_ireplace("</style","</XSS_style",$str);

        $str = str_ireplace("<iframe","<XSS_iframe",$str);
        $str = str_ireplace("</iframe","</XSS_iframe",$str);

        $str = str_ireplace("<frame","<XSS_frame",$str);
        $str = str_ireplace("</frame","</XSS_frame",$str);

        $str = str_ireplace("<form","<XSS_form",$str);
        $str = str_ireplace("</form","</XSS_form",$str);


        $str = str_ireplace("vbscript:","XSS_vbscript:",$str);
        $str = str_ireplace("javascript:","XSS_javascript:",$str);

        $str = str_ireplace("onabort","XSS_onabort",$str);
        $str = str_ireplace("onactivate","XSS_onactivate",$str);
        $str = str_ireplace("onafterprint","XSS_onafterprint",$str);
        $str = str_ireplace("onafterupdate","XSS_onafterupdate",$str);
        $str = str_ireplace("onbeforeactivate","XSS_onbeforeactivate",$str);
        $str = str_ireplace("onbeforecopy","XSS_onbeforecopy",$str);
        $str = str_ireplace("onbeforecut","XSS_onbeforecut",$str);
        $str = str_ireplace("onbeforedeactivate","XSS_onbeforedeactivate",$str);
        $str = str_ireplace("onbeforeeditfocus","XSS_onbeforeeditfocus",$str);
        $str = str_ireplace("onbeforepaste","XSS_onbeforepaste",$str);
        $str = str_ireplace("onbeforeprint","XSS_onbeforeprint",$str);
        $str = str_ireplace("onbeforeunload","XSS_onbeforeunload",$str);
        $str = str_ireplace("onbeforeupdate","XSS_onbeforeupdate",$str);
        $str = str_ireplace("onbegin","XSS_onbegin",$str);
        $str = str_ireplace("onblur","XSS_onblur",$str);
        $str = str_ireplace("onbounce","XSS_onbounce",$str);
        $str = str_ireplace("oncellchange","XSS_oncellchange",$str);
        $str = str_ireplace("onchange","XSS_onchange",$str);
        $str = str_ireplace("onclick","XSS_onclick",$str);
        $str = str_ireplace("oncontentready","XSS_oncontentready",$str);
        $str = str_ireplace("oncontentsave","XSS_oncontentsave",$str);
        $str = str_ireplace("oncontextmenu","XSS_oncontextmenu",$str);
        $str = str_ireplace("oncontrolselect","XSS_oncontrolselect",$str);
        $str = str_ireplace("oncopy","XSS_oncopy",$str);
        $str = str_ireplace("oncut","XSS_oncut",$str);
        $str = str_ireplace("ondataavailable","XSS_ondataavailable",$str);
        $str = str_ireplace("ondatasetchanged","XSS_ondatasetchanged",$str);
        $str = str_ireplace("ondatasetcomplete","XSS_ondatasetcomplete",$str);
        $str = str_ireplace("ondblclick","XSS_ondblclick",$str);
        $str = str_ireplace("ondeactivate","XSS_ondeactivate",$str);
        $str = str_ireplace("ondetach","XSS_ondetach",$str);
        $str = str_ireplace("ondocumentready","XSS_ondocumentready",$str);
        $str = str_ireplace("ondrag","XSS_ondrag",$str);
        $str = str_ireplace("ondragdrop","XSS_ondragdrop",$str);
        $str = str_ireplace("ondragend","XSS_ondragend",$str);
        $str = str_ireplace("ondragenter","XSS_ondragenter",$str);
        $str = str_ireplace("ondragleave","XSS_ondragleave",$str);
        $str = str_ireplace("ondragover","XSS_ondragover",$str);
        $str = str_ireplace("ondragstart","XSS_ondragstart",$str);
        $str = str_ireplace("ondrop","XSS_ondrop",$str);
        $str = str_ireplace("onend","XSS_onend",$str);
        $str = str_ireplace("onerror","XSS_onerror",$str);
        $str = str_ireplace("onfilterchange","XSS_onfilterchange",$str);
        $str = str_ireplace("onfinish","XSS_onfinish",$str);
        $str = str_ireplace("onfocus","XSS_onfocus",$str);
        $str = str_ireplace("onfocusin","XSS_onfocusin",$str);
        $str = str_ireplace("onfocusout","XSS_onfocusout",$str);
        $str = str_ireplace("onhelp","XSS_onhelp",$str);
        $str = str_ireplace("onhide","XSS_onhide",$str);
        $str = str_ireplace("onkeydown","XSS_onkeydown",$str);
        $str = str_ireplace("onkeypress","XSS_onkeypress",$str);
        $str = str_ireplace("onkeyup","XSS_onkeyup",$str);
        $str = str_ireplace("onlayoutcomplete","XSS_onlayoutcomplete",$str);
        $str = str_ireplace("onload","XSS_onload",$str);
        $str = str_ireplace("onlosecapture","XSS_onlosecapture",$str);
        $str = str_ireplace("onmediacomplete","XSS_onmediacomplete",$str);
        $str = str_ireplace("onmediaerror","XSS_onmediaerror",$str);
        $str = str_ireplace("onmedialoadfailed","XSS_onmedialoadfailed",$str);
        $str = str_ireplace("onmousedown","XSS_onmousedown",$str);
        $str = str_ireplace("onmouseenter","XSS_onmouseenter",$str);
        $str = str_ireplace("onmouseleave","XSS_onmouseleave",$str);
        $str = str_ireplace("onmousemove","XSS_onmousemove",$str);
        $str = str_ireplace("onmouseout","XSS_onmouseout",$str);
        $str = str_ireplace("onmouseover","XSS_onmouseover",$str);
        $str = str_ireplace("onmouseup","XSS_onmouseup",$str);
        $str = str_ireplace("onmousewheel","XSS_onmousewheel",$str);
        $str = str_ireplace("onmove","XSS_onmove",$str);
        $str = str_ireplace("onmoveend","XSS_onmoveend",$str);
        $str = str_ireplace("onmovestart","XSS_onmovestart",$str);
        $str = str_ireplace("onopenstatechange","XSS_onopenstatechange",$str);
        $str = str_ireplace("onoutofsync","XSS_onoutofsync",$str);
        $str = str_ireplace("onpaste","XSS_onpaste",$str);
        $str = str_ireplace("onpause","XSS_onpause",$str);
        $str = str_ireplace("onplaystatechange","XSS_onplaystatechange",$str);
        $str = str_ireplace("onpropertychange","XSS_onpropertychange",$str);
        $str = str_ireplace("onreadystatechange","XSS_onreadystatechange",$str);
        $str = str_ireplace("onrepeat","XSS_onrepeat",$str);
        $str = str_ireplace("onreset","XSS_onreset",$str);
        $str = str_ireplace("onresize","XSS_onresize",$str);
        $str = str_ireplace("onresizeend","XSS_onresizeend",$str);
        $str = str_ireplace("onresizestart","XSS_onresizestart",$str);
        $str = str_ireplace("onresume","XSS_onresume",$str);
        $str = str_ireplace("onreverse","XSS_onreverse",$str);
        $str = str_ireplace("onrowclick","XSS_onrowclick",$str);
        $str = str_ireplace("onrowenter","XSS_onrowenter",$str);
        $str = str_ireplace("onrowexit","XSS_onrowexit",$str);
        $str = str_ireplace("onrowout","XSS_onrowout",$str);
        $str = str_ireplace("onrowover","XSS_onrowover",$str);
        $str = str_ireplace("onrowsdelete","XSS_onrowsdelete",$str);
        $str = str_ireplace("onrowsinserted","XSS_onrowsinserted",$str);
        $str = str_ireplace("onsave","XSS_onsave",$str);
        $str = str_ireplace("onscroll","XSS_onscroll",$str);
        $str = str_ireplace("onseek","XSS_onseek",$str);
        $str = str_ireplace("onselect","XSS_onselect",$str);
        $str = str_ireplace("onselectionchange","XSS_onselectionchange",$str);
        $str = str_ireplace("onselectstart","XSS_onselectstart",$str);
        $str = str_ireplace("onshow","XSS_onshow",$str);
        $str = str_ireplace("onstart","XSS_onstart",$str);
        $str = str_ireplace("onstop","XSS_onstop",$str);
        $str = str_ireplace("onsubmit","XSS_onsubmit",$str);
        $str = str_ireplace("onsyncrestored","XSS_onsyncrestored",$str);
        $str = str_ireplace("ontimeerror","XSS_ontimeerror",$str);
        $str = str_ireplace("ontrackchange","XSS_ontrackchange",$str);
        $str = str_ireplace("onunload","XSS_onunload",$str);
        $str = str_ireplace("onurlflip","XSS_onurlflip",$str);
    }else{
		$str = $this->php4Ireplace("<script","<XSS_script",$str);
		$str = $this->php4Ireplace("</script","</XSS_script",$str);

		$str = $this->php4Ireplace("<style","<XSS_style",$str);
		$str = $this->php4Ireplace("</style","</XSS_style",$str);

		$str = $this->php4Ireplace("<iframe","<XSS_iframe",$str);
		$str = $this->php4Ireplace("</iframe","</XSS_iframe",$str);

		$str = $this->php4Ireplace("<frame","<XSS_frame",$str);
		$str = $this->php4Ireplace("</frame","</XSS_frame",$str);

		$str = $this->php4Ireplace("<form","<XSS_form",$str);
		$str = $this->php4Ireplace("</form","</XSS_form",$str);


		$str = $this->php4Ireplace("vbscript:","XSS_vbscript:",$str);
		$str = $this->php4Ireplace("javascript:","XSS_javascript:",$str);

		$str = $this->php4Ireplace("onabort","XSS_onabort",$str);
		$str = $this->php4Ireplace("onactivate","XSS_onactivate",$str);
		$str = $this->php4Ireplace("onafterprint","XSS_onafterprint",$str);
		$str = $this->php4Ireplace("onafterupdate","XSS_onafterupdate",$str);
		$str = $this->php4Ireplace("onbeforeactivate","XSS_onbeforeactivate",$str);
		$str = $this->php4Ireplace("onbeforecopy","XSS_onbeforecopy",$str);
		$str = $this->php4Ireplace("onbeforecut","XSS_onbeforecut",$str);
		$str = $this->php4Ireplace("onbeforedeactivate","XSS_onbeforedeactivate",$str);
		$str = $this->php4Ireplace("onbeforeeditfocus","XSS_onbeforeeditfocus",$str);
		$str = $this->php4Ireplace("onbeforepaste","XSS_onbeforepaste",$str);
		$str = $this->php4Ireplace("onbeforeprint","XSS_onbeforeprint",$str);
		$str = $this->php4Ireplace("onbeforeunload","XSS_onbeforeunload",$str);
		$str = $this->php4Ireplace("onbeforeupdate","XSS_onbeforeupdate",$str);
		$str = $this->php4Ireplace("onbegin","XSS_onbegin",$str);
		$str = $this->php4Ireplace("onblur","XSS_onblur",$str);
		$str = $this->php4Ireplace("onbounce","XSS_onbounce",$str);
		$str = $this->php4Ireplace("oncellchange","XSS_oncellchange",$str);
		$str = $this->php4Ireplace("onchange","XSS_onchange",$str);
		$str = $this->php4Ireplace("onclick","XSS_onclick",$str);
		$str = $this->php4Ireplace("oncontentready","XSS_oncontentready",$str);
		$str = $this->php4Ireplace("oncontentsave","XSS_oncontentsave",$str);
		$str = $this->php4Ireplace("oncontextmenu","XSS_oncontextmenu",$str);
		$str = $this->php4Ireplace("oncontrolselect","XSS_oncontrolselect",$str);
		$str = $this->php4Ireplace("oncopy","XSS_oncopy",$str);
		$str = $this->php4Ireplace("oncut","XSS_oncut",$str);
		$str = $this->php4Ireplace("ondataavailable","XSS_ondataavailable",$str);
		$str = $this->php4Ireplace("ondatasetchanged","XSS_ondatasetchanged",$str);
		$str = $this->php4Ireplace("ondatasetcomplete","XSS_ondatasetcomplete",$str);
		$str = $this->php4Ireplace("ondblclick","XSS_ondblclick",$str);
		$str = $this->php4Ireplace("ondeactivate","XSS_ondeactivate",$str);
		$str = $this->php4Ireplace("ondetach","XSS_ondetach",$str);
		$str = $this->php4Ireplace("ondocumentready","XSS_ondocumentready",$str);
		$str = $this->php4Ireplace("ondrag","XSS_ondrag",$str);
		$str = $this->php4Ireplace("ondragdrop","XSS_ondragdrop",$str);
		$str = $this->php4Ireplace("ondragend","XSS_ondragend",$str);
		$str = $this->php4Ireplace("ondragenter","XSS_ondragenter",$str);
		$str = $this->php4Ireplace("ondragleave","XSS_ondragleave",$str);
		$str = $this->php4Ireplace("ondragover","XSS_ondragover",$str);
		$str = $this->php4Ireplace("ondragstart","XSS_ondragstart",$str);
		$str = $this->php4Ireplace("ondrop","XSS_ondrop",$str);
		$str = $this->php4Ireplace("onend","XSS_onend",$str);
		$str = $this->php4Ireplace("onerror","XSS_onerror",$str);
		$str = $this->php4Ireplace("onfilterchange","XSS_onfilterchange",$str);
		$str = $this->php4Ireplace("onfinish","XSS_onfinish",$str);
		$str = $this->php4Ireplace("onfocus","XSS_onfocus",$str);
		$str = $this->php4Ireplace("onfocusin","XSS_onfocusin",$str);
		$str = $this->php4Ireplace("onfocusout","XSS_onfocusout",$str);
		$str = $this->php4Ireplace("onhelp","XSS_onhelp",$str);
		$str = $this->php4Ireplace("onhide","XSS_onhide",$str);
		$str = $this->php4Ireplace("onkeydown","XSS_onkeydown",$str);
		$str = $this->php4Ireplace("onkeypress","XSS_onkeypress",$str);
		$str = $this->php4Ireplace("onkeyup","XSS_onkeyup",$str);
		$str = $this->php4Ireplace("onlayoutcomplete","XSS_onlayoutcomplete",$str);
		$str = $this->php4Ireplace("onload","XSS_onload",$str);
		$str = $this->php4Ireplace("onlosecapture","XSS_onlosecapture",$str);
		$str = $this->php4Ireplace("onmediacomplete","XSS_onmediacomplete",$str);
		$str = $this->php4Ireplace("onmediaerror","XSS_onmediaerror",$str);
		$str = $this->php4Ireplace("onmedialoadfailed","XSS_onmedialoadfailed",$str);
		$str = $this->php4Ireplace("onmousedown","XSS_onmousedown",$str);
		$str = $this->php4Ireplace("onmouseenter","XSS_onmouseenter",$str);
		$str = $this->php4Ireplace("onmouseleave","XSS_onmouseleave",$str);
		$str = $this->php4Ireplace("onmousemove","XSS_onmousemove",$str);
		$str = $this->php4Ireplace("onmouseout","XSS_onmouseout",$str);
		$str = $this->php4Ireplace("onmouseover","XSS_onmouseover",$str);
		$str = $this->php4Ireplace("onmouseup","XSS_onmouseup",$str);
		$str = $this->php4Ireplace("onmousewheel","XSS_onmousewheel",$str);
		$str = $this->php4Ireplace("onmove","XSS_onmove",$str);
		$str = $this->php4Ireplace("onmoveend","XSS_onmoveend",$str);
		$str = $this->php4Ireplace("onmovestart","XSS_onmovestart",$str);
		$str = $this->php4Ireplace("onopenstatechange","XSS_onopenstatechange",$str);
		$str = $this->php4Ireplace("onoutofsync","XSS_onoutofsync",$str);
		$str = $this->php4Ireplace("onpaste","XSS_onpaste",$str);
		$str = $this->php4Ireplace("onpause","XSS_onpause",$str);
		$str = $this->php4Ireplace("onplaystatechange","XSS_onplaystatechange",$str);
		$str = $this->php4Ireplace("onpropertychange","XSS_onpropertychange",$str);
		$str = $this->php4Ireplace("onreadystatechange","XSS_onreadystatechange",$str);
		$str = $this->php4Ireplace("onrepeat","XSS_onrepeat",$str);
		$str = $this->php4Ireplace("onreset","XSS_onreset",$str);
		$str = $this->php4Ireplace("onresize","XSS_onresize",$str);
		$str = $this->php4Ireplace("onresizeend","XSS_onresizeend",$str);
		$str = $this->php4Ireplace("onresizestart","XSS_onresizestart",$str);
		$str = $this->php4Ireplace("onresume","XSS_onresume",$str);
		$str = $this->php4Ireplace("onreverse","XSS_onreverse",$str);
		$str = $this->php4Ireplace("onrowclick","XSS_onrowclick",$str);
		$str = $this->php4Ireplace("onrowenter","XSS_onrowenter",$str);
		$str = $this->php4Ireplace("onrowexit","XSS_onrowexit",$str);
		$str = $this->php4Ireplace("onrowout","XSS_onrowout",$str);
		$str = $this->php4Ireplace("onrowover","XSS_onrowover",$str);
		$str = $this->php4Ireplace("onrowsdelete","XSS_onrowsdelete",$str);
		$str = $this->php4Ireplace("onrowsinserted","XSS_onrowsinserted",$str);
		$str = $this->php4Ireplace("onsave","XSS_onsave",$str);
		$str = $this->php4Ireplace("onscroll","XSS_onscroll",$str);
		$str = $this->php4Ireplace("onseek","XSS_onseek",$str);
		$str = $this->php4Ireplace("onselect","XSS_onselect",$str);
		$str = $this->php4Ireplace("onselectionchange","XSS_onselectionchange",$str);
		$str = $this->php4Ireplace("onselectstart","XSS_onselectstart",$str);
		$str = $this->php4Ireplace("onshow","XSS_onshow",$str);
		$str = $this->php4Ireplace("onstart","XSS_onstart",$str);
		$str = $this->php4Ireplace("onstop","XSS_onstop",$str);
		$str = $this->php4Ireplace("onsubmit","XSS_onsubmit",$str);
		$str = $this->php4Ireplace("onsyncrestored","XSS_onsyncrestored",$str);
		$str = $this->php4Ireplace("ontimeerror","XSS_ontimeerror",$str);
		$str = $this->php4Ireplace("ontrackchange","XSS_ontrackchange",$str);
		$str = $this->php4Ireplace("onunload","XSS_onunload",$str);
		$str = $this->php4Ireplace("onurlflip","XSS_onurlflip",$str);
	}
	return $str;
}

//Magic quotes에 따른 따옴표 처리
//특수 문자 db용으로 치환
function setsAddslashes($str)
{
	$str = chkXSS($str);
	if(!get_magic_quotes_gpc())
    	return addslashes($str); //PHP의 magic_quotes 옵션이 Off 일때
	else
		return $str;
}
//db용으로 치환된 특수문자 복원		stripslashes
function getsStripslashes($str)
{
	if(!get_magic_quotes_gpc())
    	return stripslashes($str);
	else
    	return $str;
}


//로그인이 필요한 경우만 체크
// if ($_REQUEST['PHPSESSID'] && $_REQUEST['PHPSESSID'] != session_id())
// 	 echo "<meta http-equiv='refresh' content='0;url=/ge_board_v1/index.php'>";
//
//로그인 사용자에 대한 검증 세션변수는 UID사용
// if($_SESSION['MID']=='')
// {
// //	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$_CNF[charset]\">";
// //	echo "<script type='text/javascript'>alert('로그인 후에 이용하실 수 있습니다.');";
// //	echo "location.href='/mgr/member/login.php';";
// //	echo "</script>";
//
//   echo "
//    <script>
//    window.alert('로그인 후에 이용하실 수 있습니다.');
//    location.href='/ge_board_v1/index.php'
//    </script>
//    ";
//
// 	exit;
// }
?>
