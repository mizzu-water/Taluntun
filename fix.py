import re

with open('app/Controllers/AssessmentController.php', 'r', encoding='utf-8') as f:
    c = f.read()

# Replace the duplicated file content starting at public function getCollege()...
c = re.sub(r'public function getCollege\(\) \{\s*header\(\'Content-Type: application/json\'\);\s*if \(\!isset\(<\?php.*?public function getQuestions', 'public function getQuestions', c, flags=re.DOTALL)

with open('app/Controllers/AssessmentController.php', 'w', encoding='utf-8') as f:
    f.write(c)
