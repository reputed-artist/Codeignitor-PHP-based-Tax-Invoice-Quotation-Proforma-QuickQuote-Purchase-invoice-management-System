$rep = 'C:\xampp\htdocs\C4\writable\_rm_rep.txt'
Remove-Item $rep -ErrorAction SilentlyContinue
$l1 = php -l 'C:\xampp\htdocs\C4\app\Views\login.php' 2>&1 | Out-String
Add-Content $rep ("LINT: " + $l1)
curl.exe -s -o 'C:\xampp\htdocs\C4\writable\_rrm.html' 'http://127.0.0.1/C4/index.php/login'
$h = Get-Content 'C:\xampp\htdocs\C4\writable\_rrm.html' -Raw
Add-Content $rep ("bytes: " + $h.Length)
Add-Content $rep ("material eye svg: " + $h.Contains('class="svg-eye" viewBox="0 0 24 24"'))
Add-Content $rep ("eye-off svg: " + $h.Contains('class="svg-eye-off"'))
Add-Content $rep ("no fa-eye left in toggle: " + (-not $h.Contains('fa fa-eye toggle-password')))
Add-Content $rep ("showing css rules: " + $h.Contains('.toggle-password.showing .svg-eye-off'))
Add-Content $rep ("row margin reset: " + $h.Contains('#try .row{ margin-left: 0; margin-right: 0; }'))
Add-Content $rep ("col padding reset: " + $h.Contains('#try .row .col-xs-8{ padding-left: 0; padding-right: 0; }'))
Add-Content $rep ("checkbox aligned: " + $h.Contains('margin: 2px 0 14px 24px !important'))
Add-Content $rep ("label flex centered: " + $h.Contains('display: inline-flex'))
Add-Content $rep ("js showing toggle: " + $h.Contains("toggleClass('showing')"))
Add-Content $rep ("gradient intact: " + $h.Contains('linear-gradient(135deg, #667eea 0%, #3c8dbc 55%, #00c0ef 100%)'))
Add-Content $rep ("particles intact: " + $h.Contains('particlesJS'))
Add-Content $rep ("logo intact: " + $h.Contains('height="150" width="210"'))
Add-Content $rep ("AJAX intact: " + $h.Contains('loginForm'))
Add-Content $rep 'DONE'
Get-Content $rep
