<?php

namespace pfrog;

use function libAllure\util\db;

class ContentGenerator {
    public function generate() 
    {
    }

    private function getCount(string $type) 
    {
        $sql = 'SELECT count(id) AS count FROM shop WHERE type = :type';
        $stmt = db()->prepare($sql);
        $stmt->bindValue(':type', $type);
        $stmt->execute();

        $res = $stmt->fetchRowNotNull();
        $res = $res['count'];

        return $res;
    }
}
