<?php
/**
 * 온라인 상담/문의 전용 스팸봇 방지 필터
 * PHP 5.x / 7.x / 8.x 전 버전 하위 호환 구조
 */

// 명백한 스팸 키워드 목록 (도박, 성인, 불법금융, 불법의약품 등)
// * 주의: '광고', '홍보', '마케팅', '배너', '견적' 등 정상 비즈니스 용어는 절대 포함하지 않음
function get_spam_keywords() {
    return array(
        '비아그라', '시알리스', '레비트라', '정품비아', '발기부전치료',
        '카지노', '바카라', '사설토토', '토토사이트', '토토커뮤니티', '먹튀검증', '먹튀',
        '홀덤사이트', '슬롯머신', '릴게임', '온라인바카라', '바카라사이트',
        '성인사이트', '성인용품', '조건만남', '출장샵', '출장안마', '오피가이드',
        '불법대출', '당일대출', '개인돈', '월변', '일수대출', '신용불량대출',
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

    // 검사 대상 텍스트 결합 (회사명, 이름, 이메일, 직급, 메모 등)
    $text_to_check = '';
    if (isset($data['company']))  $text_to_check .= ' ' . $data['company'];
    if (isset($data['name']))     $text_to_check .= ' ' . $data['name'];
    if (isset($data['email']))    $text_to_check .= ' ' . $data['email'];
    if (isset($data['position'])) $text_to_check .= ' ' . $data['position'];
    if (isset($data['memo']))     $text_to_check .= ' ' . $data['memo'];

    // 2. URL 도배 차단 (외부 URL이 2개 이상 포함된 경우 스팸 처리, 1개는 정상 문의로 허용)
    $url_pattern = '/(https?:\/\/[^\s]+|www\.[^\s]+)/i';
    $url_matches = array();
    if (preg_match_all($url_pattern, $text_to_check, $url_matches)) {
        if (isset($url_matches[0]) && count($url_matches[0]) >= 2) {
            return array('is_spam' => true, 'reason' => 'url_overload');
        }
    }

    // 3. 스팸 키워드 검증
    $spam_keywords = get_spam_keywords();
    $text_normalized = preg_replace('/\s+/', '', $text_to_check); // 공백 제거 후 검사로 변형 우회 차단

    for ($i = 0; $i < count($spam_keywords); $i++) {
        $keyword = $spam_keywords[$i];
        if ($keyword === '') continue;

        // 원본 텍스트 및 공백 제거 텍스트 둘 다 검사
        if (function_exists('mb_strpos')) {
            if (mb_strpos($text_to_check, $keyword, 0, 'UTF-8') !== false ||
                mb_strpos($text_normalized, $keyword, 0, 'UTF-8') !== false) {
                return array('is_spam' => true, 'reason' => 'spam_keyword:' . $keyword);
            }
        } else {
            if (strpos($text_to_check, $keyword) !== false ||
                strpos($text_normalized, $keyword) !== false) {
                return array('is_spam' => true, 'reason' => 'spam_keyword:' . $keyword);
            }
        }
    }

    return array('is_spam' => false, 'reason' => '');
}
