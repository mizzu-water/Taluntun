import os
import re

views_dir = r'C:\xampp\htdocs\riasec\app\Views'
processed = 0
skipped = []

for filename in os.listdir(views_dir):
    if filename.endswith('.html') and filename != 'home.html': # We already did home.html
        filepath = os.path.join(views_dir, filename)
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check if the file has <html> tag, if not, it's already processed
        if '<html' not in content.lower():
            continue
            
        # Find everything between <main...> and </main>
        match = re.search(r'<main[^>]*>(.*?)</main>', content, re.IGNORECASE | re.DOTALL)
        if match:
            main_content = match.group(1).strip()
            # Write back
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(main_content)
            processed += 1
        else:
            # Special case for files without <main>
            skipped.append(filename)

print(f"Processed: {processed}")
if skipped:
    print(f"Skipped (no <main> tag): {', '.join(skipped)}")
