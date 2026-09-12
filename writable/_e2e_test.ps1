$out = 'C:\xampp\htdocs\C4\writable\_e2e_test.txt'
$cjs = New-Object Microsoft.PowerShell.Commands.WebRequestSession
try {
  $null = Invoke-WebRequest -Uri 'http://localhost/C4/login' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  $log = Invoke-RestMethod -Uri 'http://localhost/C4/login/userlogin' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'username=admin%40gmail.com&password=admin%40123' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  "login: " + $log.status | Out-File $out -Encoding utf8

  $sv = Invoke-RestMethod -Uri 'http://localhost/C4/layoutsettings/save' -Method POST -WebSession $cjs -ContentType 'application/x-www-form-urlencoded' -Body 'key=fixed-layout&value=1' -Headers @{'X-Requested-With'='XMLHttpRequest'} -ErrorAction Stop
  "save: " + $sv.status | Out-File $out -Append -Encoding utf8

  $page = Invoke-WebRequest -Uri 'http://localhost/C4/client/manageclients' -UseBasicParsing -WebSession $cjs -ErrorAction Stop
  "page: " + $page.StatusCode | Out-File $out -Append -Encoding utf8
  $m = [regex]::Match($page.Content, '<body[^>]*>')
  "BODY: " + $m.ToString() | Out-File $out -Append -Encoding utf8
  $ck = $page.Content.Contains('checked')
  "checkboxHasChecked: " + $ck | Out-File $out -Append -Encoding utf8
  $ix = $page.Content.IndexOf("var url = '")
  if ($ix -ge 0) { "AJAX URL snippet: " + $page.Content.Substring($ix, 80) | Out-File $out -Append -Encoding utf8 }
  "SESSION COOKIES: " + ($cjs.Cookies.__cookies | ForEach-Object { $_.Domain + $_.Name + '=' + $_.Value }) | Out-File $out -Append -Encoding utf8
} catch {
  "ERROR: " + $_.Exception.Message | Out-File $out -Append -Encoding utf8
}