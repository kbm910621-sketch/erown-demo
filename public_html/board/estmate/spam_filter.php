<?php
/**
 * 온라인 상담/문의 전용 스팸봇 방지 필터
 * PHP 5.x / 7.x / 8.x 전 버전 하위 호환 구조
 */

// 명백한 스팸 키워드 목록 (도박, 성인, 불법금융, 불법의약품 등 한글 및 영문)
// * 주의: '광고', '홍보', '마케팅', '배너', '견적' 등 정상 비즈니스 용어는 절대 포함하지 않음
function get_spam_keywords() {
    return array(
        // 불법 의약품
        '비아그라', '시알리스', '레비트라', '정품비아', '발기부전치료', 'viagra', 'cialis', 'levitra',
        // 불법 도박/게임
        '카지노', '바카라', '사설토토', '토토사이트', '토토커뮤니티', '먹튀검증', '먹튀',
        '홀덤사이트', '슬롯머신', '릴게임', '온라인바카라', '바카라사이트',
        'casino', 'baccarat', 'toto', 'holdem', 'slot',
        // 성인/불법 성매매
        '성인사이트', '성인용품', '조건만남', '출장샵', '출장안마', '오피가이드',
        // 불법 대출
        '불법대출', '당일대출', '개인돈', '월변', '일수대출', '신용불량대출',
        // 불법 리딩방
        '리딩방', '코인리딩', '주식리딩', '수익보장', '해외선물대여계좌', '선물옵션리딩'
    );
}

/**
 * 상담 문의 데이터 스팸 여부 검증
 * 
 * @param array $data 입력 데이터 (Honeypot 필드 및 문의 내용 포함)
 * @return array array('is_spam' => bool, 'reason' => string)
 */
function check_estimate_spam($data) {
    // 1. Honeypot 필드 검증 (일반 사용자 화면에 보이지 않는 필드에 값이 입력된 경우)
    if (isset($data['hp_website']) && trim($data['hp_website']) !== '') {
        return array('is_spam' => true, 'reason' => 'honeypot');
    }

    // 검사 대상 텍스트 결합 (모든 전달 필드 및 배열 요소 전체 순회)
    $text_to_check = '';
    if (is_array($data)) {
        foreach ($data as $key => $val) {
            if ($key === 'hp_website') continue;
            if (is_array($val)) {
                $text_to_check .= ' ' . implode(' ', $val);
            } else if (is_string($val) || is_numeric($val)) {
                $text_to_check .= ' ' . $val;
            }
        }
    }

    // 2. URL 도배 차단 (외부 URL이 2개 이상 포함된 경우 스팸 처리, 1개는 정상 문의로 허용)
    $url_pattern = '/(https?:\/\/[^\s]+|www\.[^\s]+)/i';
    $url_matches = array();
    if (preg_match_all($url_pattern, $text_to_check, $url_matches)) {
        if (isset($url_matches[0]) && count($url_matches[0]) >= 2) {
            return array('is_spam' => true, 'reason' => 'url_overload');
        }
    }

    // 3. 스팸 키워드 검증 (대소문자 무시 + 공백 제거 변형 매칭)
    $spam_keywords = get_spam_keywords();
    $text_lower = function_exists('mb_strtolower') ? mb_strtolower($text_to_check, 'UTF-8') : strtolower($text_to_check);
    $text_normalized = preg_replace('/\s+/', '', $text_lower); // 공백 제거 후 검사로 변형 우회 차단

    for ($i = 0; $i < count($spam_keywords); $i++) {
        $keyword = $spam_keywords[$i];
        if ($keyword === '') continue;
        $keyword_lower = function_exists('mb_strtolower') ? mb_strtolower($keyword, 'UTF-8') : strtolower($keyword);
        $keyword_norm = preg_replace('/\s+/', '', $keyword_lower);

        // 원본 텍스트 및 공백 제거 텍스트 둘 다 검사
        if (function_exists('mb_strpos')) {
            if (mb_strpos($text_lower, $keyword_lower, 0, 'UTF-8') !== false ||
                mb_strpos($text_normalized, $keyword_norm, 0, 'UTF-8') !== false) {
                return array('is_spam' => true, 'reason' => 'spam_keyword:' . $keyword);
            }
        } else {
            if (strpos($text_lower, $keyword_lower) !== false ||
                strpos($text_normalized, $keyword_norm) !== false) {
                return array('is_spam' => true, 'reason' => 'spam_keyword:' . $keyword);
            }
        }
    }

    return array('is_spam' => false, 'reason' => '');
}
