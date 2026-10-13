<?php
$lines = file('C:/Users/YohanzGlorioso/.gemini/antigravity/brain/89d06053-7cfa-43ed-9de1-4c882bb17116/.system_generated/logs/transcript_full.jsonl');
$lastInput = '';
foreach($lines as $line) {
    $data = json_decode($line, true);
    if(isset($data['type']) && $data['type'] === 'USER_INPUT') {
        $lastInput = $data['content'];
    }
}
file_put_contents('c:/xampp/htdocs/riasec/question_bank.txt', $lastInput);
