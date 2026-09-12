$f = 'C:\xampp\htdocs\C4\public\bower_components\font-awesome\css\font-awesome.min.css'
if (-not (Test-Path $f)) { Write-Output "NOT FOUND: $f"; exit 1 }
$css = Get-Content $f -Raw
$icons = @('fa-exchange','fa-plus-circle','fa-plus','fa-edit','fa-address-book','fa-book','fa-cube','fa-building','fa-quote-right','fa-file-text','fa-floppy-o','fa-barcode','fa-list','fa-bar-chart','fa-line-chart','fa-code-fork','fa-money','fa-download','fa-print','fa-users','fa-user-plus','fa-gear','fa-power-off','fa-dashboard','fa-opencart','fa-shopping-cart','fa-inr','fa-rupee','fa-cogs','fa-cog','fa-gear')
foreach ($ic in $icons) {
    $found = $css -match "\.$ic\b"
    Write-Output "$ic => $found"
}
