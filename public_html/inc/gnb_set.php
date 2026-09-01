<?php
$pageName = basename($_SERVER['PHP_SELF']); //페이지이름
$dirPage = strtolower(dirname($_SERVER['PHP_SELF'])); //폴더이름

//서브메뉴 사용여부
$use_depth = "depth_active"; //서브메뉴 사용 안할땐 주석처리

//메뉴 개수
$main_cnt = "1"; //최대 11
$sub_cnt_1 = "1"; //최대 10
$sub_cnt_2 = "9";
$sub_cnt_3 = "9";
$sub_cnt_4 = "9";
$sub_cnt_5 = "9";
$sub_cnt_6 = "9";
$sub_cnt_7 = "9";
$sub_cnt_8 = "9";
$sub_cnt_9 = "9";
$sub_cnt_10 = "9";
$sub_cnt_11 = "9";
$sub_cnt_12 = "9";

//메인 메뉴 링크 설정
$gnb_folder_1 = "/contents/a_type/a_1";
$gnb_folder_2 = "/contents/b_type/b_1";
$gnb_folder_3 = "/contents/c_type/c_1";
$gnb_folder_4 = "/contents/d_type/d_1";
$gnb_folder_5 = "/contents/e_type/e_1";
$gnb_folder_6 = "/contents/f_type/f_1";
$gnb_folder_7 = "/contents/g_type/g_1";
$gnb_folder_8 = "/contents/h_type/h_1";
$gnb_folder_9 = "/contents/i_type/i_1";
$gnb_folder_10 = "/contents/j_type/j_1";
$gnb_folder_11 = "/contents/k_type/k_1";
$gnb_folder_12 = "/board/notice/list.php";

$sub_folder_1 = "/contents/a_type/a_";
$sub_folder_2 = "/contents/b_type/b_";
$sub_folder_3 = "/contents/c_type/c_";
$sub_folder_4 = "/contents/d_type/d_";
$sub_folder_5 = "/contents/e_type/e_";
$sub_folder_6 = "/contents/f_type/f_";
$sub_folder_7 = "/contents/g_type/g_";
$sub_folder_8 = "/contents/h_type/h_";
$sub_folder_9 = "/contents/i_type/i_";
$sub_folder_10 = "/contents/j_type/j_";
$sub_folder_11 = "/contents/k_type/k_";
$sub_folder_12 = "/board/notice/list.php";

$bbs_folder_1 = "/board/notice/list.php";
$bbs_folder_2 = "/board/gallery/list.php";
$bbs_folder_3 = "/board/faq/list.php";
$bbs_folder_4 = "/board/event/list.php";
$bbs_folder_5 = "/board/estmate/write.php";
$bbs_folder_6 = "/board/user/list.php";

//메인 메뉴명
$name_gnb_1 ="포트폴리오";
$name_gnb_2 ="B_type";
$name_gnb_3 ="C_type";
$name_gnb_4 ="D_type";
$name_gnb_5 ="E_type";
$name_gnb_6 ="F_type";
$name_gnb_7 ="G_type";
$name_gnb_8 ="H_type";
$name_gnb_9 ="I_type";
$name_gnb_10 ="J_type";
$name_gnb_11 ="K_type";
$name_gnb_12 ="상담신청";

//서브A 메뉴명
$name_gnb_sub_11 ="포트폴리오";
$name_gnb_sub_12 ="a2";
$name_gnb_sub_13 ="a3";
$name_gnb_sub_14 ="a4";
$name_gnb_sub_15 ="a5";
$name_gnb_sub_16 ="a6";
$name_gnb_sub_17 ="a7";
$name_gnb_sub_18 ="a8";
$name_gnb_sub_19 ="a9";
$name_gnb_sub_110 ="a10";

//서브B 메뉴명
$name_gnb_sub_21 ="b1";
$name_gnb_sub_22 ="b2";
$name_gnb_sub_23 ="b3";
$name_gnb_sub_24 ="b4";
$name_gnb_sub_25 ="b5";
$name_gnb_sub_26 ="b6";
$name_gnb_sub_27 ="b7";
$name_gnb_sub_28 ="b8";
$name_gnb_sub_29 ="b9";
$name_gnb_sub_210 ="b10";

//서브C 메뉴명
$name_gnb_sub_31 ="c1";
$name_gnb_sub_32 ="c2";
$name_gnb_sub_33 ="c3";
$name_gnb_sub_34 ="c4";
$name_gnb_sub_35 ="c5";
$name_gnb_sub_36 ="c6";
$name_gnb_sub_37 ="c7";
$name_gnb_sub_38 ="c8";
$name_gnb_sub_39 ="c9";
$name_gnb_sub_310 ="c10";

//서브D 메뉴명
$name_gnb_sub_41 ="d1";
$name_gnb_sub_42 ="d2";
$name_gnb_sub_43 ="d3";
$name_gnb_sub_44 ="d4";
$name_gnb_sub_45 ="d5";
$name_gnb_sub_46 ="d6";
$name_gnb_sub_47 ="d7";
$name_gnb_sub_48 ="d8";
$name_gnb_sub_49 ="d9";
$name_gnb_sub_410 ="d10";

//서브E 메뉴명
$name_gnb_sub_51 ="e1";
$name_gnb_sub_52 ="e2";
$name_gnb_sub_53 ="e3";
$name_gnb_sub_54 ="e4";
$name_gnb_sub_55 ="e5";
$name_gnb_sub_56 ="e6";
$name_gnb_sub_57 ="e7";
$name_gnb_sub_58 ="e8";
$name_gnb_sub_59 ="e9";
$name_gnb_sub_510 ="e10";

//서브F 메뉴명
$name_gnb_sub_61 ="f1";
$name_gnb_sub_62 ="f2";
$name_gnb_sub_63 ="f3";
$name_gnb_sub_64 ="f4";
$name_gnb_sub_65 ="f5";
$name_gnb_sub_66 ="f6";
$name_gnb_sub_67 ="f7";
$name_gnb_sub_68 ="f8";
$name_gnb_sub_69 ="f9";
$name_gnb_sub_610 ="f10";

//서브G 메뉴명
$name_gnb_sub_71 ="g1";
$name_gnb_sub_72 ="g2";
$name_gnb_sub_73 ="g3";
$name_gnb_sub_74 ="g4";
$name_gnb_sub_75 ="g5";
$name_gnb_sub_76 ="g6";
$name_gnb_sub_77 ="g7";
$name_gnb_sub_78 ="g8";
$name_gnb_sub_79 ="g9";
$name_gnb_sub_710 ="g10";

//서브H 메뉴명
$name_gnb_sub_81 ="h1";
$name_gnb_sub_82 ="h2";
$name_gnb_sub_83 ="h3";
$name_gnb_sub_84 ="h4";
$name_gnb_sub_85 ="h5";
$name_gnb_sub_86 ="h6";
$name_gnb_sub_87 ="h7";
$name_gnb_sub_88 ="h8";
$name_gnb_sub_89 ="h9";
$name_gnb_sub_810 ="h10";

//서브I 메뉴명
$name_gnb_sub_91 ="i1";
$name_gnb_sub_92 ="i2";
$name_gnb_sub_93 ="i3";
$name_gnb_sub_94 ="i4";
$name_gnb_sub_95 ="i5";
$name_gnb_sub_96 ="i6";
$name_gnb_sub_97 ="i7";
$name_gnb_sub_98 ="i8";
$name_gnb_sub_99 ="i9";
$name_gnb_sub_910 ="i10";

//서브J 메뉴명
$name_gnb_sub_101 ="j1";
$name_gnb_sub_102 ="j2";
$name_gnb_sub_103 ="j3";
$name_gnb_sub_104 ="j4";
$name_gnb_sub_105 ="j5";
$name_gnb_sub_106 ="j6";
$name_gnb_sub_107 ="j7";
$name_gnb_sub_108 ="j8";
$name_gnb_sub_109 ="j9";
$name_gnb_sub_1010 ="j10";

//서브K 메뉴명
$name_gnb_sub_111 ="k1";
$name_gnb_sub_112 ="k2";
$name_gnb_sub_113 ="k3";
$name_gnb_sub_114 ="k4";
$name_gnb_sub_115 ="k5";
$name_gnb_sub_116 ="k6";
$name_gnb_sub_117 ="k7";
$name_gnb_sub_118 ="k8";
$name_gnb_sub_119 ="k9";
$name_gnb_sub_1110 ="k10";

//서브 게시판 메뉴명
$name_gnb_subl_1 ="공지사항";
$name_gnb_subl_2 ="갤러리";
$name_gnb_subl_3 ="자주묻는 질문";
$name_gnb_subl_4 ="이벤트";
$name_gnb_subl_5 ="신청하기";
$name_gnb_subl_6 ="사용자 게시판";

//비주얼 문구
$visual_txt_a1 ="aa 다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_a2 ="aa 언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_b1 ="b 다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_b2 ="b 언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_c1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_c2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_d1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_d2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_e1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_e2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_f1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_f2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_g1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_g2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_h1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_h2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_i1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_i2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_j1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_j2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_k1 ="다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_k2 ="언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";

$visual_txt_l1 ="커뮤니티 다년간의 종합병원 진료에서의 풍부한 임상경험을 바탕으로 ";
$visual_txt_l2 ="커뮤니티 언제나 환자의 입장에서 생각하고 최상의 의료서비스를 제공하겠습니다.";



//gnb 메인메뉴
if(strstr($dirPage,"a_type")){
    $path_current = "$name_gnb_1";
    $visual_subtxt_1 = "$visual_txt_a1";
    $visual_subtxt_2 = "$visual_txt_a2";
    $sub_bg = "sub_bg_a";
    $gnb_on_1 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"b_type")){
    $path_current = "$name_gnb_2";
    $visual_subtxt_1 = "$visual_txt_b1";
    $visual_subtxt_2 = "$visual_txt_b2";
    $sub_bg = "sub_bg_b";
    $gnb_on_2 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"c_type")){
    $path_current = "$name_gnb_3";
    $visual_subtxt_1 = "$visual_txt_c1";
    $visual_subtxt_2 = "$visual_txt_c2";
    $sub_bg = "sub_bg_c";
    $gnb_on_3 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"d_type")){
    $path_current = "$name_gnb_4";
    $visual_subtxt_1 = "$visual_txt_d1";
    $visual_subtxt_2 = "$visual_txt_d2";
    $sub_bg = "sub_bg_d";
    $gnb_on_4 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"e_type")){
    $path_current = "$name_gnb_5";
    $visual_subtxt_1 = "$visual_txt_e1";
    $visual_subtxt_2 = "$visual_txt_e2";
    $sub_bg = "sub_bg_e";
    $gnb_on_5 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"f_type")){
    $path_current = "$name_gnb_6";
    $visual_subtxt_1 = "$visual_txt_f1";
    $visual_subtxt_2 = "$visual_txt_f2";
    $sub_bg = "sub_bg_f";
    $gnb_on_6 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"g_type")){
    $path_current = "$name_gnb_7";
    $visual_subtxt_1 = "$visual_txt_g1";
    $visual_subtxt_2 = "$visual_txt_g2";
    $sub_bg = "sub_bg_g";
    $gnb_on_7 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"h_type")){
    $path_current = "$name_gnb_8";
    $visual_subtxt_1 = "$visual_txt_h1";
    $visual_subtxt_2 = "$visual_txt_h2";
    $sub_bg = "sub_bg_h";
    $gnb_on_8 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"i_type")){
    $path_current = "$name_gnb_9";
    $visual_subtxt_1 = "$visual_txt_i1";
    $visual_subtxt_2 = "$visual_txt_i2";
    $sub_bg = "sub_bg_i";
    $gnb_on_9 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"j_type")){
    $path_current = "$name_gnb_10";
    $visual_subtxt_1 = "$visual_txt_j1";
    $visual_subtxt_2 = "$visual_txt_j2";
    $sub_bg = "sub_bg_j";
    $gnb_on_10 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"k_type")){
    $path_current = "$name_gnb_11";
    $visual_subtxt_1 = "$visual_txt_k1";
    $visual_subtxt_2 = "$visual_txt_k2";
    $sub_bg = "sub_bg_k";
    $gnb_on_11 = "on";
    $depth2_on = 1;
}else if(strstr($dirPage,"board")){
    $path_current = "$name_gnb_12";
    $visual_subtxt_1 = "$visual_txt_l1";
    $visual_subtxt_2 = "$visual_txt_l2";
    $sub_bg = "sub_bg_l";
    $gnb_on_12 = "on";
    $depth2_on = 1;
}

//gnb 서브메뉴 a
if(strstr($pageName,"a_1")){
    $path_sub = "$name_gnb_sub_11";
    $sub_on_11 = "on";
}else if(strstr($pageName,"a_2")){
    $path_sub = "$name_gnb_sub_12";
    $sub_on_12 = "on";
}else if(strstr($pageName,"a_3")){
    $path_sub = "$name_gnb_sub_13";
    $sub_on_13 = "on";
}else if(strstr($pageName,"a_4")){
    $path_sub = "$name_gnb_sub_14";
    $sub_on_14 = "on";
}else if(strstr($pageName,"a_5")){
    $path_sub = "$name_gnb_sub_15";
    $sub_on_15 = "on";
}else if(strstr($pageName,"a_6")){
    $path_sub = "$name_gnb_sub_16";
    $sub_on_16 = "on";
}else if(strstr($pageName,"a_7")){
    $path_sub = "$name_gnb_sub_17";
    $sub_on_17 = "on";
}else if(strstr($pageName,"a_8")){
    $path_sub = "$name_gnb_sub_18";
    $sub_on_18 = "on";
}else if(strstr($pageName,"a_9")){
    $path_sub = "$name_gnb_sub_19";
    $sub_on_19 = "on";
}else if(strstr($pageName,"a_10")){
    $path_sub = "$name_gnb_sub_110";
    $sub_on_110 = "on";
}

//gnb 서브메뉴 b
if(strstr($pageName,"b_1")){
    $path_sub = "$name_gnb_sub_21";
    $sub_on_21 = "on";
}else if(strstr($pageName,"b_2")){
    $path_sub = "$name_gnb_sub_22";
    $sub_on_22 = "on";
}else if(strstr($pageName,"b_3")){
    $path_sub = "$name_gnb_sub_23";
    $sub_on_23 = "on";
}else if(strstr($pageName,"b_4")){
    $path_sub = "$name_gnb_sub_24";
    $sub_on_24 = "on";
}else if(strstr($pageName,"b_5")){
    $path_sub = "$name_gnb_sub_25";
    $sub_on_25 = "on";
}else if(strstr($pageName,"b_6")){
    $path_sub = "$name_gnb_sub_26";
    $sub_on_26 = "on";
}else if(strstr($pageName,"b_7")){
    $path_sub = "$name_gnb_sub_27";
    $sub_on_27 = "on";
}else if(strstr($pageName,"b_8")){
    $path_sub = "$name_gnb_sub_28";
    $sub_on_28 = "on";
}else if(strstr($pageName,"b_9")){
    $path_sub = "$name_gnb_sub_29";
    $sub_on_29 = "on";
}else if(strstr($pageName,"b_10")){
    $path_sub = "$name_gnb_sub_210";
    $sub_on_210 = "on";
}

//gnb 서브메뉴 c
if(strstr($pageName,"c_1")){
    $path_sub = "$name_gnb_sub_31";
    $sub_on_31 = "on";
}else if(strstr($pageName,"c_2")){
    $path_sub = "$name_gnb_sub_32";
    $sub_on_32 = "on";
}else if(strstr($pageName,"c_3")){
    $path_sub = "$name_gnb_sub_33";
    $sub_on_33 = "on";
}else if(strstr($pageName,"c_4")){
    $path_sub = "$name_gnb_sub_34";
    $sub_on_34 = "on";
}else if(strstr($pageName,"c_5")){
    $path_sub = "$name_gnb_sub_35";
    $sub_on_35 = "on";
}else if(strstr($pageName,"c_6")){
    $path_sub = "$name_gnb_sub_36";
    $sub_on_36 = "on";
}else if(strstr($pageName,"c_7")){
    $path_sub = "$name_gnb_sub_37";
    $sub_on_37 = "on";
}else if(strstr($pageName,"c_8")){
    $path_sub = "$name_gnb_sub_38";
    $sub_on_38 = "on";
}else if(strstr($pageName,"c_9")){
    $path_sub = "$name_gnb_sub_39";
    $sub_on_39 = "on";
}else if(strstr($pageName,"c_10")){
    $path_sub = "$name_gnb_sub_310";
    $sub_on_310 = "on";
}

//gnb 서브메뉴 d
if(strstr($pageName,"d_1")){
    $path_sub = "$name_gnb_sub_41";
    $sub_on_41 = "on";
}else if(strstr($pageName,"d_2")){
    $path_sub = "$name_gnb_sub_42";
    $sub_on_42 = "on";
}else if(strstr($pageName,"d_3")){
    $path_sub = "$name_gnb_sub_43";
    $sub_on_43 = "on";
}else if(strstr($pageName,"d_4")){
    $path_sub = "$name_gnb_sub_44";
    $sub_on_44 = "on";
}else if(strstr($pageName,"d_5")){
    $path_sub = "$name_gnb_sub_45";
    $sub_on_45 = "on";
}else if(strstr($pageName,"d_6")){
    $path_sub = "$name_gnb_sub_46";
    $sub_on_46 = "on";
}else if(strstr($pageName,"d_7")){
    $path_sub = "$name_gnb_sub_47";
    $sub_on_47 = "on";
}else if(strstr($pageName,"d_8")){
    $path_sub = "$name_gnb_sub_48";
    $sub_on_48 = "on";
}else if(strstr($pageName,"d_9")){
    $path_sub = "$name_gnb_sub_49";
    $sub_on_49 = "on";
}else if(strstr($pageName,"d_10")){
    $path_sub = "$name_gnb_sub_410";
    $sub_on_410 = "on";
}

//gnb 서브메뉴 e
if(strstr($pageName,"e_1")){
    $path_sub = "$name_gnb_sub_51";
    $sub_on_51 = "on";
}else if(strstr($pageName,"e_2")){
    $path_sub = "$name_gnb_sub_52";
    $sub_on_52 = "on";
}else if(strstr($pageName,"e_3")){
    $path_sub = "$name_gnb_sub_53";
    $sub_on_53 = "on";
}else if(strstr($pageName,"e_4")){
    $path_sub = "$name_gnb_sub_54";
    $sub_on_54 = "on";
}else if(strstr($pageName,"e_5")){
    $path_sub = "$name_gnb_sub_55";
    $sub_on_55 = "on";
}else if(strstr($pageName,"e_6")){
    $path_sub = "$name_gnb_sub_56";
    $sub_on_56 = "on";
}else if(strstr($pageName,"e_7")){
    $path_sub = "$name_gnb_sub_57";
    $sub_on_57 = "on";
}else if(strstr($pageName,"e_8")){
    $path_sub = "$name_gnb_sub_58";
    $sub_on_58 = "on";
}else if(strstr($pageName,"e_9")){
    $path_sub = "$name_gnb_sub_59";
    $sub_on_59 = "on";
}else if(strstr($pageName,"e_10")){
    $path_sub = "$name_gnb_sub_510";
    $sub_on_510 = "on";
}

//gnb 서브메뉴 f
if(strstr($pageName,"f_1")){
    $path_sub = "$name_gnb_sub_61";
    $sub_on_61 = "on";
}else if(strstr($pageName,"f_2")){
    $path_sub = "$name_gnb_sub_62";
    $sub_on_62 = "on";
}else if(strstr($pageName,"f_3")){
    $path_sub = "$name_gnb_sub_63";
    $sub_on_63 = "on";
}else if(strstr($pageName,"f_4")){
    $path_sub = "$name_gnb_sub_64";
    $sub_on_64 = "on";
}else if(strstr($pageName,"f_5")){
    $path_sub = "$name_gnb_sub_65";
    $sub_on_65 = "on";
}else if(strstr($pageName,"f_6")){
    $path_sub = "$name_gnb_sub_66";
    $sub_on_66 = "on";
}else if(strstr($pageName,"f_7")){
    $path_sub = "$name_gnb_sub_67";
    $sub_on_67 = "on";
}else if(strstr($pageName,"f_8")){
    $path_sub = "$name_gnb_sub_68";
    $sub_on_68 = "on";
}else if(strstr($pageName,"f_9")){
    $path_sub = "$name_gnb_sub_69";
    $sub_on_69 = "on";
}else if(strstr($pageName,"f_10")){
    $path_sub = "$name_gnb_sub_610";
    $sub_on_610 = "on";
}

//gnb 서브메뉴 g
if(strstr($pageName,"g_1")){
    $path_sub = "$name_gnb_sub_71";
    $sub_on_71 = "on";
}else if(strstr($pageName,"g_2")){
    $path_sub = "$name_gnb_sub_72";
    $sub_on_72 = "on";
}else if(strstr($pageName,"g_3")){
    $path_sub = "$name_gnb_sub_73";
    $sub_on_73 = "on";
}else if(strstr($pageName,"g_4")){
    $path_sub = "$name_gnb_sub_74";
    $sub_on_74 = "on";
}else if(strstr($pageName,"g_5")){
    $path_sub = "$name_gnb_sub_75";
    $sub_on_75 = "on";
}else if(strstr($pageName,"g_6")){
    $path_sub = "$name_gnb_sub_76";
    $sub_on_76 = "on";
}else if(strstr($pageName,"g_7")){
    $path_sub = "$name_gnb_sub_77";
    $sub_on_77 = "on";
}else if(strstr($pageName,"g_8")){
    $path_sub = "$name_gnb_sub_78";
    $sub_on_78 = "on";
}else if(strstr($pageName,"g_9")){
    $path_sub = "$name_gnb_sub_79";
    $sub_on_79 = "on";
}else if(strstr($pageName,"g_10")){
    $path_sub = "$name_gnb_sub_710";
    $sub_on_710 = "on";
}

//gnb 서브메뉴 h
if(strstr($pageName,"h_1")){
    $path_sub = "$name_gnb_sub_81";
    $sub_on_81 = "on";
}else if(strstr($pageName,"h_2")){
    $path_sub = "$name_gnb_sub_82";
    $sub_on_82 = "on";
}else if(strstr($pageName,"h_3")){
    $path_sub = "$name_gnb_sub_83";
    $sub_on_83 = "on";
}else if(strstr($pageName,"h_4")){
    $path_sub = "$name_gnb_sub_84";
    $sub_on_84 = "on";
}else if(strstr($pageName,"h_5")){
    $path_sub = "$name_gnb_sub_85";
    $sub_on_85 = "on";
}else if(strstr($pageName,"h_6")){
    $path_sub = "$name_gnb_sub_86";
    $sub_on_86 = "on";
}else if(strstr($pageName,"h_7")){
    $path_sub = "$name_gnb_sub_87";
    $sub_on_87 = "on";
}else if(strstr($pageName,"h_8")){
    $path_sub = "$name_gnb_sub_88";
    $sub_on_88 = "on";
}else if(strstr($pageName,"h_9")){
    $path_sub = "$name_gnb_sub_89";
    $sub_on_89 = "on";
}else if(strstr($pageName,"h_10")){
    $path_sub = "$name_gnb_sub_810";
    $sub_on_810 = "on";
}

//gnb 서브메뉴 i
if(strstr($pageName,"i_1")){
    $path_sub = "$name_gnb_sub_91";
    $sub_on_91 = "on";
}else if(strstr($pageName,"i_2")){
    $path_sub = "$name_gnb_sub_92";
    $sub_on_92 = "on";
}else if(strstr($pageName,"i_3")){
    $path_sub = "$name_gnb_sub_93";
    $sub_on_93 = "on";
}else if(strstr($pageName,"i_4")){
    $path_sub = "$name_gnb_sub_94";
    $sub_on_94 = "on";
}else if(strstr($pageName,"i_5")){
    $path_sub = "$name_gnb_sub_95";
    $sub_on_95 = "on";
}else if(strstr($pageName,"i_6")){
    $path_sub = "$name_gnb_sub_96";
    $sub_on_96 = "on";
}else if(strstr($pageName,"i_7")){
    $path_sub = "$name_gnb_sub_97";
    $sub_on_97 = "on";
}else if(strstr($pageName,"i_8")){
    $path_sub = "$name_gnb_sub_98";
    $sub_on_98 = "on";
}else if(strstr($pageName,"i_9")){
    $path_sub = "$name_gnb_sub_99";
    $sub_on_99 = "on";
}else if(strstr($pageName,"i_10")){
    $path_sub = "$name_gnb_sub_910";
    $sub_on_910 = "on";
}

//gnb 서브메뉴 j
if(strstr($pageName,"j_1")){
    $path_sub = "$name_gnb_sub_101";
    $sub_on_101 = "on";
}else if(strstr($pageName,"j_2")){
    $path_sub = "$name_gnb_sub_102";
    $sub_on_102 = "on";
}else if(strstr($pageName,"j_3")){
    $path_sub = "$name_gnb_sub_103";
    $sub_on_103 = "on";
}else if(strstr($pageName,"j_4")){
    $path_sub = "$name_gnb_sub_104";
    $sub_on_104 = "on";
}else if(strstr($pageName,"j_5")){
    $path_sub = "$name_gnb_sub_105";
    $sub_on_105 = "on";
}else if(strstr($pageName,"j_6")){
    $path_sub = "$name_gnb_sub_106";
    $sub_on_106 = "on";
}else if(strstr($pageName,"j_7")){
    $path_sub = "$name_gnb_sub_107";
    $sub_on_107 = "on";
}else if(strstr($pageName,"j_8")){
    $path_sub = "$name_gnb_sub_108";
    $sub_on_108 = "on";
}else if(strstr($pageName,"j_9")){
    $path_sub = "$name_gnb_sub_109";
    $sub_on_109 = "on";
}else if(strstr($pageName,"j_10")){
    $path_sub = "$name_gnb_sub_1010";
    $sub_on_1010 = "on";
}

//gnb 서브메뉴 k
if(strstr($pageName,"k_1")){
    $path_sub = "$name_gnb_sub_111";
    $sub_on_111 = "on";
}else if(strstr($pageName,"k_2")){
    $path_sub = "$name_gnb_sub_112";
    $sub_on_112 = "on";
}else if(strstr($pageName,"k_3")){
    $path_sub = "$name_gnb_sub_113";
    $sub_on_113 = "on";
}else if(strstr($pageName,"k_4")){
    $path_sub = "$name_gnb_sub_114";
    $sub_on_114 = "on";
}else if(strstr($pageName,"k_5")){
    $path_sub = "$name_gnb_sub_115";
    $sub_on_115 = "on";
}else if(strstr($pageName,"k_6")){
    $path_sub = "$name_gnb_sub_116";
    $sub_on_116 = "on";
}else if(strstr($pageName,"k_7")){
    $path_sub = "$name_gnb_sub_117";
    $sub_on_117 = "on";
}else if(strstr($pageName,"k_8")){
    $path_sub = "$name_gnb_sub_118";
    $sub_cnt_118_on_8 = "on";
}else if(strstr($pageName,"k_9")){
    $path_sub = "$name_gnb_sub_119";
    $sub_on_119 = "on";
}else if(strstr($pageName,"k_10")){
    $path_sub = "$name_gnb_sub_1110";
    $sub_on_1110 = "on";
}

//gnb 서브메뉴 게시판
if(strstr($dirPage,"notice")){
    $path_sub = "$name_gnb_subl_1";
    $sub_on_bd1 = "on";
}else if(strstr($dirPage,"gallery")){
    $path_sub = "$name_gnb_subl_2";
    $sub_on_bd2 = "on";
}else if(strstr($dirPage,"faq")){
    $path_sub = "$name_gnb_subl_3";
    $sub_on_bd3 = "on";
}else if(strstr($dirPage,"event")){
    $path_sub = "$name_gnb_subl_4";
    $sub_on_bd4 = "on";
}else if(strstr($dirPage,"estmate")){
    $path_sub = "$name_gnb_subl_5";
    $sub_on_bd5 = "on";
}else if(strstr($dirPage,"user")){
    $path_sub = "$name_gnb_subl_6";
    $sub_on_bd6 = "on";
}
?>
