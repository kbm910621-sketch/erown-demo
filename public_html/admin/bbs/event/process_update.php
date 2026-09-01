<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/common.php";

$ev_uid = $_POST['ev_uid'];
$ev_title = chkXSS($_POST['ev_title']);
$ev_description = chkXSS($_POST['ev_description']);


// 파일전송
if($_FILES['userfile']['name'][0]){ // 첫번째 파일이 있을때 코드를 실행합니다.
    $total = count($_FILES['userfile']['name']); // 전체 파일업로드 수
    for($i=0; $i<$total; $i++) {
        $target_name = strtolower($_FILES['userfile']['name'][$i]);
        $size = $_FILES['userfile']['size'][$i];

        // 파일 사이즈 체크
        if($size > 5242880){
            alert("용량은 5MB 이하");
        }

        if($size > 0){ // 파일사이즈 비교
            $file_exp = explode(".",$target_name); //파일명과 확장자 구분
            $file_name = $file_exp[count($file_exp)-2.3]; //파일명만 가져오기
            $file_type = $file_exp[count($file_exp)-1]; //확장자만 가져오기
            // $img_type = ['jpg','jpeg','gif','png']; //이미지 확장자 종류를 배열에 넣는다. 7버전
            $img_type = array("jpg", "jpeg", "gif", "png");
            if(array_search($file_type, $img_type) === false){
                alert("이미지가 아닙니다");
            }

            $rantime = date("mdhis", time());  //날짜 (월,일,시간,분,초)
            $file[] = chr(rand(97,122)).chr(rand(97,122)).$rantime.rand(1,9).rand(1,9).".".$file_type; //파일명 생성;

            $dir="uploads/";  //업로드할 디렉터리 지정
            move_uploaded_file($_FILES["userfile"]["tmp_name"][$i],$dir.$file[$i]); //파일업로드
            chmod($dir.$file[$i],0777); //수정권한

            //기존 파일삭제
            $sql = "SELECT * FROM news WHERE ev_uid = $ev_uid";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $del_file= 'uploads/'.$row['ev_file'.$i];
            if($row['ev_file'.$i] && is_file($del_file)) unlink($del_file);

            $file_db = 'ev_file'.$i;

            $sql = "
            UPDATE event
            SET
                $file_db = '$file[$i]'
            WHERE
                ev_uid = '$ev_uid'
            ";
            $result = mysqli_query($conn, $sql);
        }
    }
}


//쿼리전송
$sql = "
UPDATE event
SET
    ev_title = '$ev_title',
    ev_description = '$ev_description'
WHERE
    ev_uid = '$ev_uid'
";

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($conn));
} else {
    echo "<script type='text/javascript'>alert('글을 수정했습니다');";
    echo "location.href='list.php';";
    echo "</script>";
    //header('location: author.php'); //redirect
}
?>
