
<html>
<head> <title>Print Envelop </title>
  <?= $this->include('include/links.php');?>
<style>
body {
  background: rgb(204,204,204); 
  margin: 0mm 25mm 25mm 25mm;
}
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
  width: 25cm;
  height: 16cm; 
}

@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}

 *[contenteditable] {
  border-radius: 0.25em;
  min-width: 1em;
  outline: 0;
  cursor: pointer;
}
*[contenteditable]:hover {
  background: #def;
  box-shadow: 0 0 1em 0.5em #def;
}
*[contenteditable]:focus {
  background: #def;
  box-shadow: 0 0 1em 0.5em #def;
}

 img {
    image-rendering: -webkit-optimize-contrast !important;
  }
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
-webkit-print-color-adjust: exact;
  }
}


.final td {
   background-color: #000000 !important;
   color: white !important;   
}

blockquote {
    border: none !important; /* Remove any border */
    padding: 20px 10px 30px 30px; /* Keep padding */
    margin: 0; /* Remove extra margins */
}

@media print {
    blockquote {
        border: none !important; /* Ensure no border when printing */
        background: transparent !important; /* Remove any background */
    }
}


@media print {
body {-webkit-print-color-adjust: exact;}
}
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body style="background-color: gray">



<page size="A4">
  <table width="945" height="342" border="0" style="border-width:thin;margin-top: 130px">
    <tr>
      <td width="320" height="134"><div align="center" style="padding-left: 70px; margin-left: 100px;">
      <img src="<?= base_url() ?>/public/dist/img/black.png" alt="logo" width="200" height="130"></div></td>
      <td colspan="2" valign="top"><p>&nbsp; </p>
     
          <blockquote style="border-color: none;padding: 20px 10px 0px 30px;">
            <p style="font-weight: bold"> Office : A4/1 Suryanagar Soc., Jawahar Chowk, Maninagar, Ahmedabad, Gujarat - 380008 (India)</p>
            <p style="font-weight: bold"> Mob : +91-9737693302 / 7016419537 / 8511369124</p>
          </blockquote>
      </td>
    </tr>
    </br>
    <?php if (!empty($dta)) : ?>
    <?php foreach ($dta as $row) : ?>
        <tr>
      <td height="123" colspan="2" valign="top">&nbsp;</td>
      <td width="454" valign="top" style="padding-top: 20px"><p  style="margin-left:50px; font-size: 18px;"> To, </br>
<b style="font-size: 18px;" contenteditable>M/s. <?= esc($row['name']) ?> </b></br> 
<b style="font-size: 18px;" contenteditable>  <?php
       $x = 30;
$longString =esc($row['address']);
$lines = explode("\n", wordwrap($longString, $x));

//echo "lines:".count($lines)." ";

for($num = 0; $num < count($lines); $num += 1){ 
    //echo  $lines[$num]. "\n <br>";

     $data[$num]=$lines[$num];
} 


for($num=0;$num<count($lines);$num++)
{
   $data[$num]."</br>";
}

if($data[0] != null)
{
  echo $data[0]."</br>";
}

 if(isset($data[1]) != null)
{
  echo $data[1]."</br>";
} 

 if(isset($data[2]) != null)
{
  echo $data[2]."</br>";
}

if(isset($data[3]) != null)
{
  echo $data[3]."</br>";
}
  echo "Mob: ". esc($row['mob']);
 ?> 

 </b> </p>
      <p>&nbsp;</p></td>
      <td width="22">&nbsp;</td>
    </tr>

<?php endforeach; ?>
 <?php else : ?>
        <p>No delivery details found.</p>
    <?php endif; ?>

    <tr>
      <td class="final" height="75" colspan="4" valign="middle" bordercolor="#F0F0F0" bgcolor="#000000" style="padding-left: 80px"><p align="center" class="style1">Manufacturer: Inkjet Printers, TIJ, Conveyor, stracker, Dispensor, Stereo printers, Manual coder,</p>
      <p align="center" class="style1">Semi-automatic coder, Automatic coders, HP cartridge &amp; consumables</p></td>
    </tr>
  </table>
     

</page>
<span class="printInvisible no-print" style="color: white;" align="center"><h2><p align="center" >Set Layout: Landscape
And Then Print</p></h2>
<p><img src="<?= base_url()?>/public/dist/img/lj-load-envelopes-front-tray.gif"> </p>
</span>
</body>
</html>
