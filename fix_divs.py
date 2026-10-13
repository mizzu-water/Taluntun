import os
import re

directory = r"c:\xampp\htdocs\riasec"

# This regex matches the end of the mobile menu where multiple </div> tags have accumulated,
# right before the <main> or next section tag.
# We will look specifically for the closing of the auth buttons inside the mobile menu.
pattern = re.compile(r'(<a href="signup\.html"[^>]*>Sign Up</a>\s*</div>\s*</div>\s*</div>)(?:\s*</div>)*\s*(<(?:main|section|div id="app"|div class="bg))')

count = 0
for root, _, files in os.walk(directory):
    if "PHPMailer" in root: continue
    for file in files:
        if file.endswith(".html"):
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()
            
            # Fix the multiple </div> tags
            new_content = pattern.sub(r'\1\n        \2', content)
            
            if new_content != content:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_content)
                print(f"Fixed: {file}")
                count += 1

print(f"Done. Fixed {count} files.")
