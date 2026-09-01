//form 체크 함수		[메세지 자동 출력됨]
/*
		if(!chkForm(엘리먼트id, alert용 메세지, input인지 select인지, 최소자리수)) return;
EX]	if(!chkForm('userid', '아이디를 ', 'input', '6')) return;
*/
var chkForm = function(objs,titles,types,minlens){
	var objs = document.getElementById(objs);

	var typesmsg = '';
	var objsTrim = $.trim(objs.value);

	if(types=='input') typesmsg = ' 입력해';
	else if(types=='select') typesmsg = ' 선택해';

	if(objsTrim==""){


//		alert(titles+" "+typesmsg+" 주세요");
		alert(titles+typesmsg+'주세요.','')


		if(objs.type!="textarea"){
			objs.focus();
		}
		return false;
	}
	if(minlens!=0&&objsTrim.length<minlens){
		alert(titles+ " 최소 "+minlens+"자리 이상으로 기입해주세요.");
		if(objs.type!="textarea"){
			objs.focus();
		}
		return false;
	}
	return true;
}

// // 폼 검증 함수
// function checkForm(f) {
//     var fLen = f.elements.length;
//     var fObj;   // 폼 요소
//     var fTyp;   // 폼 요소 Type
//     var fVal;   // 폼 요소 Value
//     var fMsg;   // 경고 메시지 속성
//     var fNum;   // 숫자만 입력 속성
//     var fMax;   // 최대 길이 지정
//     var fMin;   // 최소 길이 지정
//     var fMxN;   // 최대값 지정
//     var fMnN;   // 최소값 지정
//     var fMal;   // 메일 FORMAT
//
//     for (i=0;i getLen(fVal)) {
//         if (fMax != null && fMax < getLen(fVal)) {
//             alert("입력된 글자수가 "+fMax+"자보다 커야합니다.");
//             fObj.focus(); return false;
//         }
//         if (fMxN != null && parseInt(fMxN) < parseInt(fVal)) {
//             alert("입력된 숫자는 "+fMxN+"보다 작아야합니다.");
//             fObj.focus(); return false;
//         }
//         if (fMnN != null && parseInt(fMnN) > parseInt(fVal)) {
//             alert("입력된 숫자는 "+fMnN+"보다 커야합니다.");
//             fObj.focus(); return false;
//         }
//         if (fMal != null && checkEmail(fVal) == false && fVal != "") {
//             alert("이메일 주소가 올바르지 않습니다");
//             fObj.focus(); return false;
//         }
//     }
//     return true;
// }
//
// // 폼에 해당하는 컨트롤들의 기본값 쉽게 셋팅해 주기
// function initForm(f)    {
//     var nLen;   // form 요소의 갯수
//     var ival;   // 각 요소의 default value 값 즉! 초기화하고자 하는값
//     var fTyp;   // form 요소의 타입(select, radio, checkbox...)
//     for (var i = 0; i < f.elements.length; i++) {
//         fTyp = toUpperCase(f.elements[i].type);
//         ival = f.elements[i].ival;
//
//         if (ival && fTyp == "SELECT-ONE") {
//             nLen = f.elements[i].options.length;
//             for (var j = 0; j < nLen; j++) {
//                 if (f.elements[i].options[j].value == ival)
//                     f.elements[i].options[j].selected = true;
//             }
//         }
//         if (fTyp == "SELECT-MULTIPLE") {
//             nLen = f.elements[i].options.length;
//             for (var j = 0; j < nLen; j++) {
//                 if (f.elements[i].options[j].value == f.elements[i].options[j].ival)
//                     f.elements[i].options[j].selected = true;
//             }
//         }
//         if (ival && (fTyp == "RADIO" || fTyp == "CHECKBOX")) {
//             if (f.elements[i].value == ival)
//                 f.elements[i].checked = true;
//         }
//     }
//     return true;
// }
//
// // 배열 요소일 경우 checked 된것이 있는지 확인
// function checkChecked(obj) {
//     var objnm = obj.name;
//     var oElem = eval("document.all."+objnm);
//     var oElem = eval(fname+"."+objnm);
//     var ret = false;
//
//     if (typeof(oElem.length) == "undefined") {
//         if (oElem.checked) {
//             ret = true;
//         }
//     } else {
//         for (var i=0;i 4)
//             tot_cnt += 2;
//         else
//             tot_cnt++;
//     }
//     return tot_cnt;
// }
//
// // 대문자 변환 ex) toUpperCase(문자)
// function toUpperCase(str) {
//     var ret;
//     str != null ? ret = str.toUpperCase() : ret = "";
//     return ret;
// }
