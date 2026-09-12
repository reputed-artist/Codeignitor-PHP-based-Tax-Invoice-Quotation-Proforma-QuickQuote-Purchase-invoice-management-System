$out = 'C:\xampp\htdocs\C4\writable\_e2e4.txt'
$cjs = New-Object Microsoft.PowerShell.Commands.WebRequestSession
try {
  $r1 = Invoke-WebRequest -Uri 'http://localhost/C4/login' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  "login GET: " + $r1.StatusCode | Out-File $out -Encoding utf8
  $r2 = Invoke-WebRequest -Uri 'http://localhost/C4/login/userlogin' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'username=admin%40gmail.com&password=admin%40123' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  "login POST: " + $r2.StatusCode | Out-File $out -Append -Encoding utf8
  $r3 = Invoke-WebRequest -Uri 'http://localhost/C4/client/manageclients' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  "manageclients GET: " + $r3.StatusCode | Out-File $out -Append -Encoding utf8
  "is-html: " + $r3.Content.TrimStart().StartsWith('<') | Out-File $out -Append -Encoding utf8
  "starts: " + $r3.Content.Substring(0, [Math]::Min(80, $r3.Content.Length)) | Out-File $out -Append -Encoding utf8
} catch {
  "ERROR: " + $_.Exception.Message | Out-File $out -Append -Encoding utf8
}