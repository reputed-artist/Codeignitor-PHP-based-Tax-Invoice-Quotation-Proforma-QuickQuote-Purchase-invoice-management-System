$out = 'C:\xampp\htdocs\C4\writable\_e2e2.txt'
$html = 'C:\xampp\htdocs\C4\writable\_page.html'
$cjs = New-Object Microsoft.PowerShell.Commands.WebRequestSession
try {
  $r1 = Invoke-WebRequest -Uri 'http://localhost/C4/login' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  "STEP1 GET login: " + $r1.StatusCode | Out-File $out -Encoding utf8
  "Set-Cookie1: " + ($r1.Headers['Set-Cookie'] | Out-String) | Out-File $out -Append -Encoding utf8

  $r2 = Invoke-WebRequest -Uri 'http://localhost/C4/login/userlogin' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'username=admin%40gmail.com&password=admin%40123' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  "STEP2 POST login: " + $r2.StatusCode | Out-File $out -Append -Encoding utf8
  "login body: " + $r2.Content | Out-File $out -Append -Encoding utf8
  "Set-Cookie2: " + ($r2.Headers['Set-Cookie'] | Out-String) | Out-File $out -Append -Encoding utf8

  $r3 = Invoke-WebRequest -Uri 'http://localhost/C4/layoutsettings/save' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'key=fixed-layout&value=1' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  "STEP3 POST save: " + $r3.StatusCode | Out-File $out -Append -Encoding utf8
  "save body: " + $r3.Content | Out-File $out -Append -Encoding utf8
  "Set-Cookie3: " + ($r3.Headers['Set-Cookie'] | Out-String) | Out-File $out -Append -Encoding utf8

  $r4 = Invoke-WebRequest -Uri 'http://localhost/C4/client/manageclients' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  "STEP4 GET manageclients: " + $r4.StatusCode | Out-File $out -Append -Encoding utf8
  $r4.Content | Out-File $html -Encoding utf8
  "saved html len: " + $r4.Content.Length | Out-File $out -Append -Encoding utf8
} catch {
  "ERROR: " + $_.Exception.Message | Out-File $out -Append -Encoding utf8
}