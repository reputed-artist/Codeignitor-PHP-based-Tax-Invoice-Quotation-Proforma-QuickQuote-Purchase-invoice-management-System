$out = 'C:\xampp\htdocs\C4\writable\_e2e3.txt'
$html = 'C:\xampp\htdocs\C4\writable\_dash.html'
$cjs = New-Object Microsoft.PowerShell.Commands.WebRequestSession
try {
  $null = Invoke-WebRequest -Uri 'http://localhost/C4/login' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  $null = Invoke-RestMethod -Uri 'http://localhost/C4/login/userlogin' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'username=admin%40gmail.com&password=admin%40123' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  $null = Invoke-RestMethod -Uri 'http://localhost/C4/layoutsettings/save' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'key=fixed-layout&value=1' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  $r = Invoke-WebRequest -Uri 'http://localhost/C4/dashboard' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  "dashboard status: " + $r.StatusCode | Out-File $out -Encoding utf8
  "dashboard len: " + $r.Content.Length | Out-File $out -Append -Encoding utf8
  $r.Content | Out-File $html -Encoding utf8
} catch {
  "ERROR: " + $_.Exception.Message | Out-File $out -Append -Encoding utf8
}