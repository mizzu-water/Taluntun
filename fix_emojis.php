<?php
$file = 'app/Views/assessment.html';
$html = file_get_contents($file);

// 1. Replace the button emoji array with HTML entities
$pattern1 = '/<button v-for="\(emoji, index\) in \[[^]]+\]"/s';
$replacement1 = '<button v-for="(emoji, index) in [\'&#x1F621;\', \'&#x1F641;\', \'&#x1F610;\', \'&#x1F642;\', \'&#x1F60D;\']"';
$html = preg_replace($pattern1, $replacement1, $html);

// 2. Replace the milestone emojis with Unicode escapes
$pattern2 = '/if \(percent === 25\).*?showMilestone\.value = true;/s';
$replacement2 = 'if (percent === 25) {
    milestoneTitle.value = "Great Start!";
    milestoneMessage.value = "You\'re 25% done. Keep that momentum going!";
    milestoneEmoji.value = "\uD83D\uDE80";
} else if (percent === 50) {
    milestoneTitle.value = "Halfway There!";
    milestoneMessage.value = "You\'re crushing it. 50% complete!";
    milestoneEmoji.value = "\uD83D\uDD25";
} else if (percent === 75) {
    milestoneTitle.value = "Almost Done!";
    milestoneMessage.value = "Just the final stretch left. You got this!";
    milestoneEmoji.value = "\u2B50";
}

showMilestone.value = true;';
$html = preg_replace($pattern2, $replacement2, $html);

// Save using PHP's robust file handling
file_put_contents($file, $html);
echo "Emojis fixed with HTML entities and Unicode escapes!";
?>
