$dir = "c:\xampp\htdocs\riasec"
$files = Get-ChildItem -Path $dir -Filter "*.html" -Recurse | Where-Object { $_.FullName -notmatch "PHPMailer" }

$count = 0
foreach ($f in $files) {
    $content = Get-Content $f.FullName -Raw -Encoding UTF8
    
    # We look for the Sign Up button, then exactly 3 closing divs which belong to the mobile menu,
    # then ANY number of extra closing divs and whitespace, followed by <main or <section or <div class="bg
    # We replace it with just the 3 closing divs and the next tag.
    $pattern = '(?s)(<a href="signup\.html"[^>]*>Sign Up</a>\s*</div>\s*</div>\s*</div>)(?:\s*</div>)*\s*(<(?:main|section))'
    
    $newContent = [regex]::Replace($content, $pattern, '$1`r`n        $2')
    
    # Also handle index.html where it's <div id="app"> instead of <main>
    # But wait, <div id="app"> is at the VERY TOP of the body, wrapping the header. So it shouldn't be matched here.
    # The thing following the header is usually <main> or <section>.

    if ($newContent -ne $content) {
        Set-Content -Path $f.FullName -Value $newContent -Encoding UTF8
        Write-Host "Fixed $($f.Name)"
        $count++
    }
}
Write-Host "Done. Fixed $count files."
