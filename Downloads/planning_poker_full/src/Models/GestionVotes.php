<?php
class GestionVotes {

    public static function isUnanimous(array $votes) {
        $valid = array_filter($votes, function($v){ return $v !== 'cafe'; });
        if (count($valid) === 0) return false;
        $first = null;
        foreach ($valid as $v) {
            if ($first === null) $first = $v;
            if ($v !== $first) return false;
        }
        return true;
    }

    public static function allCafe(array $votes) {
        if (count($votes) === 0) return false;
        foreach ($votes as $v) {
            if ($v !== 'cafe') return false;
        }
        return true;
    }

    public static function moyenne(array $votes) {
        $vals = array_map('floatval', array_filter($votes, function($v){ return $v !== 'cafe'; }));
        if (count($vals) === 0) return null;
        return array_sum($vals)/count($vals);
    }

    public static function mediane(array $votes) {
        $vals = array_map('floatval', array_filter($votes, function($v){ return $v !== 'cafe'; }));
        if (count($vals) === 0) return null;
        sort($vals);
        $n = count($vals);
        $mid = intdiv($n, 2);
        if ($n % 2 === 1) return $vals[$mid];
        return ($vals[$mid - 1] + $vals[$mid]) / 2;
    }

    public static function majoriteAbsolue(array $votes) {
        $counts = [];
        foreach ($votes as $v) {
            if ($v === 'cafe') continue;
            $counts[$v] = ($counts[$v] ?? 0) + 1;
        }
        if (empty($counts)) return null;
        arsort($counts);
        $top = key($counts);
        $topCount = current($counts);
        $total = count(array_filter($votes, function($v){ return $v !== 'cafe'; }));
        if ($topCount > $total/2) return $top;
        return null;
    }

    public static function majoriteRelative(array $votes) {
        $counts = [];
        foreach ($votes as $v) {
            if ($v === 'cafe') continue;
            $counts[$v] = ($counts[$v] ?? 0) + 1;
        }
        if (empty($counts)) return null;
        arsort($counts);
        return key($counts);
    }
}
