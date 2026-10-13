$lines = Get-Content "C:\Users\mm\.gemini\antigravity\brain\3c8e8f5c-d7fc-4ddf-bba7-c56968c35638\.system_generated\logs\transcript_full.jsonl"
for ($i = $lines.Count - 1; $i -ge 0; $i--) {
    if ($lines[$i] -match "Vue\.createApp" -and $lines[$i] -match "results\.html") {
        # check if it contains the full script
        if ($lines[$i] -match '(?s)(const\s+app\s*=\s*Vue\.createApp.*?app\.mount\(''#app''\);)') {
            # Since JSON escapes newlines as \n, we need to unescape it
            $scriptStr = $Matches[1]
            $scriptStr = $scriptStr -replace '\\n', "`n"
            $scriptStr = $scriptStr -replace '\\"', '"'
            Set-Content extract.txt -Value $scriptStr -Encoding UTF8
            Write-Host "Found in line $i. Length: $($scriptStr.Length)"
            exit
        }
    }
}
Write-Host "Not found"
