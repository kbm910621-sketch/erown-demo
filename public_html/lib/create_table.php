<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db_conn.php";

$sql = "
  CREATE TABLE member (
    adm_uid int(11) NOT NULL auto_increment COMMENT '번호',
    adm_id varchar(100) NOT NULL COMMENT '아이디',
    adm_name varchar(100) DEFAULT NULL COMMENT '이름',
    adm_pw varchar(200) NOT NULL COMMENT '비밀번호',
    adm_regdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    adm_pwdchange timestamp NULL DEFAULT NULL COMMENT '비밀번호변경일',
    PRIMARY KEY  (adm_uid)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='관리자정보';
";

$sql .= "
  CREATE TABLE user (
    user_uid int(11) NOT NULL auto_increment COMMENT '번호',
    user_title varchar(200) NOT NULL COMMENT '제목',
    user_name varchar(50) NOT NULL COMMENT '작성자',
    user_pwd varchar(50) NOT NULL COMMENT '비밀번호',
    user_description text NOT NULL COMMENT '내용',
    user_regdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    user_hit int(11) NOT NULL COMMENT '조회수',
    PRIMARY KEY  (user_uid)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='사용자정보';
";

$sql .= "
  CREATE TABLE title (
    `tit_uid` int(11) NOT NULL auto_increment COMMENT '번호',
    `tit_ch1` varchar(200) NOT NULL COMMENT '제목1',
    `tit_ch2` varchar(200) NOT NULL COMMENT '제목2',
    `tit_ch3` varchar(200) NOT NULL COMMENT '제목3',
    `tit_ch4` varchar(200) NOT NULL COMMENT '제목4',
    `tit_ch5` varchar(200) NOT NULL COMMENT '제목5',
    `tit_ch6` varchar(200) NOT NULL COMMENT '제목6',
    `tit_ch7` varchar(200) NOT NULL COMMENT '제목7',
    `tit_ch8` varchar(200) NOT NULL COMMENT '제목8',
    `tit_ch9` varchar(200) NOT NULL COMMENT '제목9',
    `tit_ch10` varchar(200) NOT NULL COMMENT '제목10',
    `tit_ch11` varchar(200) NOT NULL COMMENT '제목11',
    `tit_ch12` varchar(200) NOT NULL COMMENT '제목12',
    `tit_ch13` varchar(200) NOT NULL COMMENT '제목13',
    PRIMARY KEY  (`tit_uid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='사이트제목';
";

$sql .= "
  CREATE TABLE keyword (
    `key_uid` int(11) NOT NULL auto_increment COMMENT '번호',
    `key_ch1` varchar(250) NOT NULL COMMENT '사이트 제목',
    `key_ch2` varchar(250) NOT NULL COMMENT '사이트 주소',
    `key_ch3` varchar(250) NOT NULL COMMENT '사이트 대표 이미지 주소',
    `key_ch4` varchar(250) NOT NULL COMMENT '키워드',
    `key_ch5` varchar(250) NOT NULL COMMENT '요약설명',
    PRIMARY KEY  (`key_uid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='사이트 키워드';
";

$sql .= "
  CREATE TABLE popup (
    `pop_uid` int(11) NOT NULL auto_increment COMMENT '번호',
    `pop_title` varchar(200) NOT NULL COMMENT '제목',
    `pop_start` date NOT NULL COMMENT '시작일',
    `pop_end` date NOT NULL COMMENT '종료일',
    `pop_view` char(1) NOT NULL COMMENT '노출여부',
    `pop_top` int(11) NOT NULL COMMENT '상단',
    `pop_left` int(11) NOT NULL COMMENT '왼쪽',
    `pop_width` int(11) NOT NULL COMMENT '가로크기',
    `pop_file0` varchar(200) NOT NULL COMMENT '파일명',
    `pop_regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    PRIMARY KEY  (`pop_uid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='팝업등록';
";

$sql .= "
  CREATE TABLE notice (
    notice_uid int(11) NOT NULL auto_increment COMMENT '번호',
    notice_title varchar(200) NOT NULL COMMENT '제목',
    notice_description text NOT NULL COMMENT '내용',
    notice_author varchar(50) NOT NULL COMMENT '작성자',
    notice_file0 varchar(200) NOT NULL COMMENT '첨부파일',
    notice_regdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    notice_hit int(11) NOT NULL COMMENT '조회수',
    PRIMARY KEY  (notice_uid)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='공지사항';
";

$sql .= "
  CREATE TABLE qna (
    qn_uid int(11) NOT NULL auto_increment COMMENT '번호',
    qn_title varchar(200) NOT NULL COMMENT '제목',
    qn_description text NOT NULL COMMENT '내용',
    qn_author varchar(50) NOT NULL COMMENT '작성자',
    qn_regdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    qn_hit int(11) NOT NULL COMMENT '조회수',
    PRIMARY KEY  (qn_uid)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='자주묻는질문';
";

$sql .= "
  CREATE TABLE photo (
    ph_uid int(11) NOT NULL auto_increment COMMENT '번호',
    ph_title varchar(200) NOT NULL COMMENT '제목',
    ph_description text NOT NULL COMMENT '내용',
    ph_author varchar(50) NOT NULL COMMENT '작성자',
    ph_file0 varchar(200) NOT NULL COMMENT '첨부파일1',
    ph_file1 varchar(200) NOT NULL COMMENT '첨부파일2',
    ph_file2 varchar(200) NOT NULL COMMENT '첨부파일3',
    ph_file3 varchar(200) NOT NULL COMMENT '첨부파일4',
    ph_file4 varchar(200) NOT NULL COMMENT '첨부파일5',
    ph_regdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    ph_hit int(11) NOT NULL COMMENT '조회수',
    PRIMARY KEY  (ph_uid)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='갤러리';
";

$sql .= "
  CREATE TABLE event (
    ev_uid int(11) NOT NULL auto_increment COMMENT '번호',
    ev_title varchar(200) NOT NULL COMMENT '제목',
    ev_description text NOT NULL COMMENT '내용',
    ev_author varchar(50) NOT NULL COMMENT '작성자',
    ev_file0 varchar(200) NOT NULL COMMENT '첨부파일',
    ev_file1 varchar(200) NOT NULL COMMENT '첨부파일',
    ev_regdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    ev_hit int(11) NOT NULL COMMENT '조회수',
    PRIMARY KEY  (ev_uid)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='이벤트';
";

$sql .= "
  CREATE TABLE estmate (
    `est_uid` int(11) NOT NULL auto_increment COMMENT '번호',
    `est_type` varchar(100) NOT NULL COMMENT '종류',
    `est_name` varchar(50) NOT NULL COMMENT '신청자명',
    `est_gender` varchar(50) NOT NULL COMMENT '성별',
    `est_phone` varchar(50) NOT NULL COMMENT '연락처',
    `est_email` varchar(100) NOT NULL COMMENT '이메일',
    `est_address` varchar(100) NOT NULL COMMENT '주소',
    `est_location` varchar(100) NOT NULL COMMENT '지역',
    `est_visit` date NOT NULL COMMENT '방문일',
    `est_regdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    PRIMARY KEY  (`est_uid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='상담안내';
";

$sql .= "
INSERT INTO member
(adm_id, adm_name, adm_pw, adm_regdate, adm_pwdchange)
VALUES (
    'admin',
    '관리자',
    md5(1111),
    NOW(),
    NOW()
);
";

$sql .= "
INSERT INTO title
(tit_ch1, tit_ch2, tit_ch3, tit_ch4, tit_ch5, tit_ch6, tit_ch7, tit_ch8, tit_ch9, tit_ch10, tit_ch11, tit_ch12, tit_ch13)
VALUES (
    '메인 타이틀',
    '서브 타이틀 A',
    '서브 타이틀 B',
    '서브 타이틀 C',
    '서브 타이틀 D',
    '서브 타이틀 E',
    '서브 타이틀 F',
    '서브 타이틀 G',
    '서브 타이틀 H',
    '서브 타이틀 I',
    '서브 타이틀 J',
    '서브 타이틀 K',
    '서브 타이틀 L'
);
";

$sql .= "
INSERT INTO keyword
(key_ch1, key_ch2, key_ch3, key_ch4, key_ch5)
VALUES (
    '메인 타이틀',
    'http://사이트주소',
    'http://대표이미지주소',
    'keywords',
    'description'
);
";

// $sql .= "
//   CREATE TABLE GNB (
//     `gnb_uid` int(11) NOT NULL auto_increment COMMENT '번호',
//     `gnb_folder1` varchar(100) NOT NULL COMMENT '폴더명a',
//     `gnb_folder2` varchar(100) NOT NULL COMMENT '폴더명b',
//     `gnb_folder3` varchar(100) NOT NULL COMMENT '폴더명c',
//     `gnb_folder4` varchar(100) NOT NULL COMMENT '폴더명d',
//     `gnb_folder5` varchar(100) NOT NULL COMMENT '폴더명e',
//     `gnb_folder6` varchar(100) NOT NULL COMMENT '폴더명f',
//     `gnb_folder7` varchar(100) NOT NULL COMMENT '폴더명g',
//     `gnb_folder8` varchar(100) NOT NULL COMMENT '폴더명h',
//     `gnb_folder9` varchar(100) NOT NULL COMMENT '폴더명i',
//     `gnb_folder10` varchar(100) NOT NULL COMMENT '폴더명j',
//     `gnb_main_cnt` int(11) NOT NULL COMMENT '메인메뉴 개수',
//     `gnb_suba_cnt` int(11) NOT NULL COMMENT '서브메뉴1 개수',
//     `gnb_subb_cnt` int(11) NOT NULL COMMENT '서브메뉴2 개수',
//     `gnb_subc_cnt` int(11) NOT NULL COMMENT '서브메뉴3 개수',
//     `gnb_subd_cnt` int(11) NOT NULL COMMENT '서브메뉴4 개수',
//     `gnb_sube_cnt` int(11) NOT NULL COMMENT '서브메뉴5 개수',
//     `gnb_subf_cnt` int(11) NOT NULL COMMENT '서브메뉴6 개수',
//     `gnb_subg_cnt` int(11) NOT NULL COMMENT '서브메뉴7 개수',
//     `gnb_subh_cnt` int(11) NOT NULL COMMENT '서브메뉴8 개수',
//     `gnb_subi_cnt` int(11) NOT NULL COMMENT '서브메뉴9 개수',
//     `gnb_subj_cnt` int(11) NOT NULL COMMENT '서브메뉴10 개수',
//     `gnb_main1` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main2` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main3` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main4` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main5` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main6` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main7` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main8` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main9` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_main10` varchar(100) NOT NULL COMMENT '메인메뉴',
//     `gnb_suba0` varchar(100) NOT NULL COMMENT 'suba0',
//     `gnb_suba1` varchar(100) NOT NULL COMMENT 'suba1',
//     `gnb_suba2` varchar(100) NOT NULL COMMENT 'suba2',
//     `gnb_suba3` varchar(100) NOT NULL COMMENT 'suba3',
//     `gnb_suba4` varchar(100) NOT NULL COMMENT 'suba4',
//     `gnb_suba5` varchar(100) NOT NULL COMMENT 'suba5',
//     `gnb_suba6` varchar(100) NOT NULL COMMENT 'suba6',
//     `gnb_suba7` varchar(100) NOT NULL COMMENT 'suba7',
//     `gnb_suba8` varchar(100) NOT NULL COMMENT 'suba8',
//     `gnb_suba9` varchar(100) NOT NULL COMMENT 'suba9',
//     `gnb_suba10` varchar(100) NOT NULL COMMENT 'suba10',
//     `gnb_subb0` varchar(100) NOT NULL COMMENT 'subb0',
//     `gnb_subb1` varchar(100) NOT NULL COMMENT 'subb1',
//     `gnb_subb2` varchar(100) NOT NULL COMMENT 'subb2',
//     `gnb_subb3` varchar(100) NOT NULL COMMENT 'subb3',
//     `gnb_subb4` varchar(100) NOT NULL COMMENT 'subb4',
//     `gnb_subb5` varchar(100) NOT NULL COMMENT 'subb5',
//     `gnb_subb6` varchar(100) NOT NULL COMMENT 'subb6',
//     `gnb_subb7` varchar(100) NOT NULL COMMENT 'subb7',
//     `gnb_subb8` varchar(100) NOT NULL COMMENT 'subb8',
//     `gnb_subb9` varchar(100) NOT NULL COMMENT 'subb9',
//     `gnb_subb10` varchar(100) NOT NULL COMMENT 'subb10',
//     `gnb_subc0` varchar(100) NOT NULL COMMENT 'subc0',
//     `gnb_subc1` varchar(100) NOT NULL COMMENT 'subc1',
//     `gnb_subc2` varchar(100) NOT NULL COMMENT 'subc2',
//     `gnb_subc3` varchar(100) NOT NULL COMMENT 'subc3',
//     `gnb_subc4` varchar(100) NOT NULL COMMENT 'subc4',
//     `gnb_subc5` varchar(100) NOT NULL COMMENT 'subc5',
//     `gnb_subc6` varchar(100) NOT NULL COMMENT 'subc6',
//     `gnb_subc7` varchar(100) NOT NULL COMMENT 'subc7',
//     `gnb_subc8` varchar(100) NOT NULL COMMENT 'subc8',
//     `gnb_subc9` varchar(100) NOT NULL COMMENT 'subc9',
//     `gnb_subc10` varchar(100) NOT NULL COMMENT 'subc10',
//     `gnb_subd0` varchar(100) NOT NULL COMMENT 'subd0',
//     `gnb_subd1` varchar(100) NOT NULL COMMENT 'subd1',
//     `gnb_subd2` varchar(100) NOT NULL COMMENT 'subd2',
//     `gnb_subd3` varchar(100) NOT NULL COMMENT 'subd3',
//     `gnb_subd4` varchar(100) NOT NULL COMMENT 'subd4',
//     `gnb_subd5` varchar(100) NOT NULL COMMENT 'subd5',
//     `gnb_subd6` varchar(100) NOT NULL COMMENT 'subd6',
//     `gnb_subd7` varchar(100) NOT NULL COMMENT 'subd7',
//     `gnb_subd8` varchar(100) NOT NULL COMMENT 'subd8',
//     `gnb_subd9` varchar(100) NOT NULL COMMENT 'subd9',
//     `gnb_subd10` varchar(100) NOT NULL COMMENT 'subd10',
//     `gnb_sube0` varchar(100) NOT NULL COMMENT 'sube0',
//     `gnb_sube1` varchar(100) NOT NULL COMMENT 'sube1',
//     `gnb_sube2` varchar(100) NOT NULL COMMENT 'sube2',
//     `gnb_sube3` varchar(100) NOT NULL COMMENT 'sube3',
//     `gnb_sube4` varchar(100) NOT NULL COMMENT 'sube4',
//     `gnb_sube5` varchar(100) NOT NULL COMMENT 'sube5',
//     `gnb_sube6` varchar(100) NOT NULL COMMENT 'sube6',
//     `gnb_sube7` varchar(100) NOT NULL COMMENT 'sube7',
//     `gnb_sube8` varchar(100) NOT NULL COMMENT 'sube8',
//     `gnb_sube9` varchar(100) NOT NULL COMMENT 'sube9',
//     `gnb_sube10` varchar(100) NOT NULL COMMENT 'sube10',
//     `gnb_subf0` varchar(100) NOT NULL COMMENT 'subf0',
//     `gnb_subf1` varchar(100) NOT NULL COMMENT 'subf1',
//     `gnb_subf2` varchar(100) NOT NULL COMMENT 'subf2',
//     `gnb_subf3` varchar(100) NOT NULL COMMENT 'subf3',
//     `gnb_subf4` varchar(100) NOT NULL COMMENT 'subf4',
//     `gnb_subf5` varchar(100) NOT NULL COMMENT 'subf5',
//     `gnb_subf6` varchar(100) NOT NULL COMMENT 'subf6',
//     `gnb_subf7` varchar(100) NOT NULL COMMENT 'subf7',
//     `gnb_subf8` varchar(100) NOT NULL COMMENT 'subf8',
//     `gnb_subf9` varchar(100) NOT NULL COMMENT 'subf9',
//     `gnb_subf10` varchar(100) NOT NULL COMMENT 'subf10',
//     `gnb_subg0` varchar(100) NOT NULL COMMENT 'subg0',
//     `gnb_subg1` varchar(100) NOT NULL COMMENT 'subg1',
//     `gnb_subg2` varchar(100) NOT NULL COMMENT 'subg2',
//     `gnb_subg3` varchar(100) NOT NULL COMMENT 'subg3',
//     `gnb_subg4` varchar(100) NOT NULL COMMENT 'subg4',
//     `gnb_subg5` varchar(100) NOT NULL COMMENT 'subg5',
//     `gnb_subg6` varchar(100) NOT NULL COMMENT 'subg6',
//     `gnb_subg7` varchar(100) NOT NULL COMMENT 'subg7',
//     `gnb_subg8` varchar(100) NOT NULL COMMENT 'subg8',
//     `gnb_subg9` varchar(100) NOT NULL COMMENT 'subg9',
//     `gnb_subg10` varchar(100) NOT NULL COMMENT 'subg10',
//     `gnb_subh0` varchar(100) NOT NULL COMMENT 'subh0',
//     `gnb_subh1` varchar(100) NOT NULL COMMENT 'subh1',
//     `gnb_subh2` varchar(100) NOT NULL COMMENT 'subh2',
//     `gnb_subh3` varchar(100) NOT NULL COMMENT 'subh3',
//     `gnb_subh4` varchar(100) NOT NULL COMMENT 'subh4',
//     `gnb_subh5` varchar(100) NOT NULL COMMENT 'subh5',
//     `gnb_subh6` varchar(100) NOT NULL COMMENT 'subh6',
//     `gnb_subh7` varchar(100) NOT NULL COMMENT 'subh7',
//     `gnb_subh8` varchar(100) NOT NULL COMMENT 'subh8',
//     `gnb_subh9` varchar(100) NOT NULL COMMENT 'subh9',
//     `gnb_subh10` varchar(100) NOT NULL COMMENT 'subh10',
//     `gnb_subi0` varchar(100) NOT NULL COMMENT 'subi0',
//     `gnb_subi1` varchar(100) NOT NULL COMMENT 'subi1',
//     `gnb_subi2` varchar(100) NOT NULL COMMENT 'subi2',
//     `gnb_subi3` varchar(100) NOT NULL COMMENT 'subi3',
//     `gnb_subi4` varchar(100) NOT NULL COMMENT 'subi4',
//     `gnb_subi5` varchar(100) NOT NULL COMMENT 'subi5',
//     `gnb_subi6` varchar(100) NOT NULL COMMENT 'subi6',
//     `gnb_subi7` varchar(100) NOT NULL COMMENT 'subi7',
//     `gnb_subi8` varchar(100) NOT NULL COMMENT 'subi8',
//     `gnb_subi9` varchar(100) NOT NULL COMMENT 'subi9',
//     `gnb_subi10` varchar(100) NOT NULL COMMENT 'subi10',
//     `gnb_subj0` varchar(100) NOT NULL COMMENT 'subj0',
//     `gnb_subj1` varchar(100) NOT NULL COMMENT 'subj1',
//     `gnb_subj2` varchar(100) NOT NULL COMMENT 'subj2',
//     `gnb_subj3` varchar(100) NOT NULL COMMENT 'subj3',
//     `gnb_subj4` varchar(100) NOT NULL COMMENT 'subj4',
//     `gnb_subj5` varchar(100) NOT NULL COMMENT 'subj5',
//     `gnb_subj6` varchar(100) NOT NULL COMMENT 'subj6',
//     `gnb_subj7` varchar(100) NOT NULL COMMENT 'subj7',
//     `gnb_subj8` varchar(100) NOT NULL COMMENT 'subj8',
//     `gnb_subj9` varchar(100) NOT NULL COMMENT 'subj9',
//     `gnb_subj10` varchar(100) NOT NULL COMMENT 'subj10',
//     PRIMARY KEY  (`gnb_uid`)
//   ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='메인메뉴';
// ";
//
// $sql .= "
// INSERT INTO GNB
// (gnb_folder1, gnb_folder2, gnb_folder3, gnb_folder4, gnb_folder5, gnb_folder6, gnb_folder7, gnb_folder8, gnb_folder9, gnb_folder10 )
// VALUES (
//     'a_type',
//     'b_type',
//     'c_type',
//     'd_type',
//     'e_type',
//     'f_type',
//     'g_type',
//     'h_type',
//     'i_type',
//     'j_type'
// );
// ";

$result = mysqli_multi_query($conn, $sql);
if($result === false){
  echo 'error';
  error_log(mysqli_error($conn));
} else {
  echo 'ok';
}

?>
