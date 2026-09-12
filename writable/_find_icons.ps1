$f='C:\xampp\htdocs\C4\app\Views\Include\sidebar.php'
$c=Get-Content $f
foreach($i in 1..$c.Count){
    if($c[$i-1] -match 'fa-[a-z]+'){
        Write-Host ("{0}: {1}" -f $i, $c[$i-1])
    }
}
