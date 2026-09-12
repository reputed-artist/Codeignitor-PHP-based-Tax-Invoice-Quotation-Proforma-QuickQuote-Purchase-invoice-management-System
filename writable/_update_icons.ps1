$f = 'C:\xampp\htdocs\C4\app\Views\Include\sidebar.php'
$c = Get-Content $f -Raw

# Define replacements: old icon string -> new icon string (only FA4 icons verified present)
$replacements = @{
    'fa-calculator'   = 'fa-address-book'
    'fa-user'          = 'fa-user-plus'
    'fa-user-plus'     = 'fa-plus-circle'
    'fa-gears'         = 'fa-building'
    'fa-opencart'      = 'fa-shopping-cart'
    'fa-list'          = 'fa-list-ul'
    'fa-rupee'         = 'fa-money'
    'fa-print'         = 'fa-cog'
    'fa-download'      = 'fa-bar-chart'
}

foreach ($old in $replacements.Keys) {
    $new = $replacements[$old]
    $oldTag = "class=\"fa fa-fw $old\""
    $newTag = "class=\"fa fa-fw $new\""
    $c = $c -replace [regex]::Escape($oldTag), $newTag
    Write-Output "Replaced: $old -> $new"
}

# Also fix the FA5 fa-search-dollar -> FA4 fa-quote-right (already done manually, but ensure no others)
$c = $c -replace 'fas fa-search-dollar', 'fa fa-fw fa-quote-right'

# Fix glyphicon -> FA4 fa icons
$c = $c -replace 'glyphicon glyphicon-floppy-saved', 'fa fa-floppy-o'
$c = $c -replace 'glyphicon glyphicon-barcode', 'fa fa-barcode'
$c = $c -replace 'glyphicon glyphicon-fire', 'fa fa-fire-extinguisher'

# Add missing fa-fw to whatsapp icon for alignment
$c = $c -replace '<i class="fa fa-whatsapp">', '<i class="fa fa-fw fa-whatsapp">'

Set-Content $f $c -NoNewline
Write-Output "All icon replacements applied. File saved."
