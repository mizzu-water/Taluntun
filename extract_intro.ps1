$lines = Get-Content "C:\Users\mm\.gemini\antigravity\brain\3c8e8f5c-d7fc-4ddf-bba7-c56968c35638\.system_generated\logs\transcript_full.jsonl"
for ($i = $lines.Count - 1; $i -ge 0; $i--) {
    if ($lines[$i] -match "Vue\.createApp" -and $lines[$i] -match "course-intro\.html") {
        if ($lines[$i] -match '(?s)(const\s+app\s*=\s*Vue\.createApp.*?app\.mount\(''#app''\);)') {
            $scriptStr = $Matches[1]
            $scriptStr = $scriptStr -replace '\\n', "`n"
            $scriptStr = $scriptStr -replace '\\"', '"'
            Set-Content extract_intro.txt -Value $scriptStr -Encoding UTF8
            Write-Host "Found in line $i"
            exit
        }
    }
}
Write-Host "Not found"
