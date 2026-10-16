
# This script adds a working mobile menu to every HTML page that has a burger button.
# It inserts: 1) id on the burger button, 2) a mobile nav drawer after the header,
# 3) JS at the bottom of the body to wire it all together.

$pages = @{
    "landing.html"     = @("landing.html","colleges.html","degrees.html","scholarships.html","holland.html")
    "colleges.html"    = @("landing.html","colleges.html","degrees.html","scholarships.html","holland.html")
    "degrees.html"     = @("landing.html","colleges.html","degrees.html","scholarships.html","holland.html")
    "scholarships.html"= @("landing.html","colleges.html","degrees.html","scholarships.html","holland.html")
    "holland.html"     = @("landing.html","colleges.html","degrees.html","scholarships.html","holland.html")
    "index.html"       = @("landing.html","index.html","results.html")
    "results.html"     = @("landing.html","index.html","results.html")
    "login.html"       = $null
    "signup.html"      = $null
}

$rootDir = "c:\xampp\htdocs\riasec"
$files = Get-ChildItem -Path $rootDir -Filter "*.html" -File

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw -Encoding UTF8

    # Skip if already patched
    if ($content -match 'id="burgerBtn"') {
        Write-Host "Already patched: $($file.Name)"
        continue
    }

    # Skip files without a burger button
    if ($content -notmatch 'class="lg:hidden p-1 text-gray-600"') {
        Write-Host "No burger found, skipping: $($file.Name)"
        continue
    }

    # 1) Add id to the burger button
    $content = $content -replace 'class="lg:hidden p-1 text-gray-600"', 'id="burgerBtn" class="lg:hidden p-1 text-gray-600"'

    # 2) Find nav links for this file to build the mobile menu
    $navLinks = @()
    if ($content -match 'href="landing\.html"') { $navLinks += @{ href="landing.html"; label="Home" } }
    if ($content -match 'href="colleges\.html"') { $navLinks += @{ href="colleges.html"; label="Colleges" } }
    if ($content -match 'href="degrees\.html"') { $navLinks += @{ href="degrees.html"; label="Degree Programs" } }
    if ($content -match 'href="scholarships\.html"') { $navLinks += @{ href="scholarships.html"; label="Scholarships" } }
    if ($content -match 'href="holland\.html"') { $navLinks += @{ href="holland.html"; label="Holland Codes" } }
    if ($content -match 'href="index\.html".*Take Assessment') { $navLinks += @{ href="index.html"; label="Take Assessment" } }
    if ($content -match 'href="results\.html"') { $navLinks += @{ href="results.html"; label="My Results" } }

    # Build link HTML
    $linkHtml = ""
    foreach ($link in $navLinks) {
        $linkHtml += "        <a href=`"$($link.href)`" class=`"block px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-emerald-700 rounded-lg transition`">$($link.label)</a>`n"
    }

    $mobileMenu = @"

    <!-- Mobile Menu Drawer -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-lg px-4 py-3 space-y-1">
$linkHtml        <div class="border-t border-gray-100 pt-3 mt-2 flex flex-col gap-2">
            <a href="login.html" class="block text-center text-sm font-bold text-gray-700 border border-gray-300 rounded-full px-5 py-2 hover:bg-gray-50 transition">Log In</a>
            <a href="signup.html" class="block text-center text-sm font-bold text-white bg-[#0f2e21] rounded-full px-5 py-2 hover:bg-black transition">Sign Up</a>
        </div>
    </div>
"@

    # 3) Insert mobile menu right after </header>
    $content = $content -replace '(</header>)', "`$1$mobileMenu"

    # 4) Add burger JS before </body>
    $burgerJs = @"
    <script>
        // Burger menu toggle
        (function() {
            const btn  = document.getElementById('burgerBtn');
            const menu = document.getElementById('mobileMenu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!menu.contains(e.target) && e.target !== btn) {
                    menu.classList.add('hidden');
                }
            });
        })();
    </script>
"@

    $content = $content -replace '(</body>)', "$burgerJs`$1"

    Set-Content -Path $file.FullName -Value $content -Encoding UTF8
    Write-Host "Patched: $($file.Name)"
}

Write-Host "`nAll done!"
