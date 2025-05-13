

<html>
<head>
<title> Purchase Invoice </title>
<?= $this->include('include/links.php');?>

<style type="text/css">

body {
  background: rgb(204,204,204); 
}
page {

  background: white;
  display: block;
  margin: 10 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  padding-top: 26px;
}
page{  

  width: 25cm;
  height: 35cm;
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


.style1 {
  font-size: 16px;
  font-weight: bold;
}
.style2 {font-size: 16px}

td{
padding-left:2px;
}

#lr{
  border-left:1px solid black;border-right:1px solid black;
}
#br{
  border-right:1px solid black;border-bottom:1px solid black;
}
#tr
{
   border-top:1px solid black; border-right:1px solid black;
}
img {
    image-rendering: -webkit-optimize-contrast !important;
  }
</style>

</head>

<body>
<div id="loader"></div>
<page size="A4">
<?php if ((!$companyDetails) && (!$invDetails[0])): ?>
    <p>No company details available.</p>
<?php else: ?>

<table width="816" height="1056" cellpadding="0" cellspacing="0" style="font-family:calibri;margin-top:10px;" align="center">
  <col width="31" />
  <col width="201" />
  <col width="61" />
  <col width="87" />
  <col width="72" />
  <col width="77" />
  <col width="57" />
  <col width="73" />

  
  
  <tr height="13">
    <!-- <td height="13" colspan="8" style="border:1px solid black;"><img src="<?= base_url(); ?>/public/dist/img/sticker Letter black Pad.png" height="200px" width="870px">  </td> -->
  </tr>


    <tr height="26">
  
    <td colspan="8" height="24" style="border:1px solid black;border-bottom:0px;font-size:20px"><div style="text-align: center;"><strong style="font-size:24px;text-align: center; " >Purchase Invoice</strong></div></td>
  </tr>    
  <tr height="13">
    <td height="13" colspan="8" style="border:1px solid black;">&nbsp;</td>
  </tr>

    <tr height="20">
    <td colspan="3" height="20" style="border:1px solid black;border-bottom:0px;">&nbsp; Supplier</td>
    <td colspan="2" id="tr">Invoice No.</td>
    <td colspan="3" id="tr">Dated</td>
  </tr>
  <tr height="20">
    <td colspan="3" height="20" id="lr">&nbsp; <strong style="font-size: 18px;">M/s. 
 <?=$invDetails[0]['c_name'];?></strong></td>
    <td colspan="2" id="br" contenteditable><b><?= $invDetails[0]['invid']; ?></b></td>
    <td colspan="3" id="br"><b><?php  $c=date("d-M-Y",strtotime($invDetails[0]['invdate']));
                                      echo $c; ?></b></td>
  </tr>
 
  <tr height="24">
    <td colspan="3" height="24" id="lr" >&nbsp; <?php 

       $x = 40;
$longString =$invDetails[0]['c_add'];
$lines = explode("\n", wordwrap($longString, $x));

//echo count($lines);


for($num = 0; $num < count($lines); $num += 1){ 
    //echo  $lines[$num]. "\n <br>";

     $data[$num]=$lines[$num];
} 


for($num=0;$num<count($lines);$num++)
{
   $data[$num]."<br>";
}

if($data[0] != null)
{
  echo $data[0]."</br>";
}

// 


      ?></td>
    <td colspan="2" style="border-right:1px solid black;">Buyer's Order No.</td>
    <td colspan="3" style="border-right:1px solid black;">Dated</td>
  </tr>


  <tr height="23" contenteditable>
    <td colspan="3" height="24" contenteditable id="lr" style="padding-left: 10px;" contenteditable><?php if(isset($data[1]) != null)
{
  echo $data[1]."</br>";
} ?> 
   

     </td>
    <td colspan="2" id="br">&nbsp;</td>
    <td colspan="3" id="br">&nbsp;</td>
  </tr>
  <tr height="23">
    <td colspan="3" height="24" id="lr" style="padding-left: 10px;" contenteditable><?php if(isset($data[2]) != null)
{
  echo $data[2]."</br>";
} ?></td>
    <td colspan="2" style="border-right:1px solid black;">Dispatch through</td>
    <td colspan="3" style="border-right:1px solid black;">Mode/Terms of Payment</td>
  </tr>
  <tr height="23">
    <td colspan="3" height="24" id="lr" style="padding-left: 10px;border-bottom: 1px solid black;" contenteditable><?php if(isset($data[3]) != null)
   {
    echo $data[3]."</br>";
   } ?>
  <?=   "<b>"."Mob:".$invDetails[0]['mob']."<b>"."</br>"; ?>
  <?php   $country = $invDetails[0]['country'];
      $gst=$invDetails[0]['gst'];

       if($country =="India")
       {
       if(strlen($gst)==10)
      {
        echo "Pan 1: ".$new=strtoupper($gst);
      }
      if (strlen($gst)==12) {
          echo "Adhaar : ".$new=strtoupper($gst);
      }
      if(strlen($gst)==15)
      {
     echo "GSTIN/UIN : ".$new=strtoupper($gst);
   } 
 }
  if ($country =="Nepal")
  {
    //echo "enter nepal";
    //echo rtrim($gst);
  //echo strlen($gst);

    if(strlen($gst)==15)
      {
     echo "Exim Code : ".$new=strtoupper($gst);
   }
    if(strlen($gst)==9)
      {
     echo "Nepal Pan : ".$new=strtoupper($gst);
   }
 }
?>
   </td>
    <td colspan="2" id="br" contenteditable><strong></strong></td>
    <td colspan="3" id="br"  contenteditable><b>NEFT</b></td>
  </tr>
 
 <tr style="border-left:1px solid black; border-bottom: 0px;" contenteditable>
  <td colspan="3" id="lr" style="padding-left: 10px;" contenteditable><!-- <?php //if(isset($data[3]) != null)
  {
    //echo $data[3];
   } ?>
 --> 
 <?= "Buyer."."</br>";?>    
     <?= "<b>"."M/s. ".$companyDetails['c_name']."</b>"."</br>";?>
      <?php 

       $x = 40;
$longString =$companyDetails['c_add'];
$lines = explode("\n", wordwrap($longString, $x));

//echo count($lines);


for($num = 0; $num < count($lines); $num += 1){ 
    //echo  $lines[$num]. "\n <br>";

     $data2[$num]=$lines[$num];
} 


for($num=0;$num<count($lines);$num++)
{
   $data2[$num]."<br>";
}

if($data2[0] != null)
{
  echo $data2[0]."</br>";
}

if($data2[1] != null)
{
  echo $data2[1]."</br>";
}
// if($data2[2] != null)
// {
//   echo $data2[2]."</br>";
// }
// if($data[3] != null)
// {
//   echo $data[3]."</br>";
// }



      ?>
   
   </td> 


    <!-- <td colspan="2"  contenteditable><strong></strong></td> -->
    <!-- <?php //if($deliveryDetails != null){ ?> -->

    <td colspan="5" id="br" style="border: 0px; border-left:1px solid black;border-right: 1px solid black" contenteditable>Terms of Delivery</td>
    <?php  //}?>
  </tr>
  <tr height="23" contenteditable>
    <td colspan="3" height="23" id="lr"><strong>&nbsp;&nbsp;<?=  "<b>"."Mob:".$companyDetails['mob']."<b>"."</br>"; ?> </strong></td>
    <td colspan="5" style="border-right:1px solid black;">

    <b>
    <?php //if($deliveryDetails != null){ echo "M/s.".$deliveryDetails['name'];} ?></b></td>
  </tr>

  <tr height="23" contenteditable>
    <td colspan="3" height="23" id="lr" contenteditable><strong>&nbsp;
      <?php
     
      $country = $invDetails[0]['country'];
      $gst=$invDetails[0]['gst'];

       if($country =="India")
       {
       if(strlen($gst)==10)
      {
        echo "Pan : ".$new=strtoupper($gst);
      }
      if (strlen($gst)==12) {
          echo "Adhaar : ".$new=strtoupper($gst);
      }
      if(strlen($gst)==15)
      {
     echo "GSTIN/UIN : ".$new=strtoupper($gst);
   } 
 }
  if ($country =="Nepal")
  {
    //echo "enter nepal";
    //echo rtrim($gst);
  //echo strlen($gst);

    if(strlen($gst)==15)
      {
     echo "Exim Code : ".$new=strtoupper($gst);
   }
    if(strlen($gst)==9)
      {
     echo "Nepal Pan : ".$new=strtoupper($gst);
   }
 }
   ?></strong></td>
    <td colspan="5" style="border-right:1px solid black;"><?php //if($deliveryDetails != null){ echo $deliveryDetails['address'];} ?></td>
  </tr>
  <tr height="13">
    <td colspan="3" height="13" style="border:1px solid black;border-top:0px; "></td>
    <td height="15" colspan="5" id="br" contenteditable><b><?php //if($deliveryDetails !=null){ echo "Mob: ".$deliveryDetails['mob'];} ?></b></td>

  </tr>
  


  <tr height="35">
    <td height="35" width="38" style="border:1px solid black;border-top:0px; "><div align="center"><strong>Sr. No.</strong></div></td>
    <td colspan="2" id="br"><div align="center"><strong>Description of Goods</strong></div></td>
    <td id="br"><div align="center"><strong>HSN/SAC</strong></div></td>
    <td width="114" id="br"><div align="center"><strong>Quantity</strong></div></td>
    <td width="94" id="br"><div align="center"><strong>Rate</strong></div></td>
    <td width="37" id="br"><div align="center"><strong>per</strong></div></td>
    <td width="102" id="br"><div align="center" ><strong>Amount</strong></div></td>
  </tr>
<?php 

// $ord=mysqli_query($con,"select orderid from invtest2 where invid='$val'");

// $ds=mysqli_fetch_array($ord);

// $dsdata=$ds[0];

// //echo $dsdata;

// $cnt=0;
// $cs=mysqli_query($con,"select * from invtest where orderid='$dsdata'");

// $num=mysqli_num_rows($cs);

// if(mysqli_num_rows($cs)==0)
// {
//   echo "invoice not created";
// }
// while($ro=mysqli_fetch_array($cs))
//   {
// $cnt++;
//       if(strtok($ro['item_name']," ") == "Courier" or strtok($ro['item_name']," ") == "Wooden Packing" or strtok($ro['item_name']," ") == "Freight" or strtok($ro['item_name']," ") == "Packing")
//       {
       
?>

<?php 
  $cnt=1;
  $totalItems = count($itemDetails);
//echo "Total Items: " . $totalItems;

  foreach ($itemDetails as $item): ?>
           
        
 <tr height="21">
    <td height="25" id="lr"><div align="center" ><?= $cnt++; ?></div></td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;<?= $item['item_name']; ?></td>
    <td style="border-right:1px solid black;"><div align="center" ><?= $item['hsn'];  ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?= number_format($item['quantity'],2); ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?= number_format($item['price'],2);  ?></div></td>
    <td style="border-right:1px solid black;"><div align="center"> No. </div></td>
    <td style="border-right:1px solid black;"><div align="center"><?= number_format($item['total'],2); ?></div></td>
  </tr>

<?php if($item['item_desc'] != null)
{?>  
  <tr height="21">
    <td height="25" id="lr"><div align="center" ></div></td>
    <td colspan="2" style="border-right:1px solid black; padding-left: 20px !important;">&nbsp;<?= "(".$item['item_desc'].")"; ?></td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center">  </div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
  </tr>
 <?php } ?> 
<?php endforeach; ?>


<?php if($totalItems > 1)
{?>
<tr height="18">
    <td height="10" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;"> &nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?php echo "------------------"; ?></div></td>
  </tr>
  <tr height="18">
    <td height="18" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;"> &nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"><?= number_format($invDetails[0]['subtotal'],2); ?></div></td>
  </tr>
<?php } ?>

  <?php
  $list=0;
      if($totalItems > 5)
      {
        $list = 2;
      }
      if($totalItems == 5)
      {
        $list=4;
      }
      if($totalItems == 4)
      {
        $list=3;
      }  
      if($totalItems == 3)
      {
        $list=4;
      }
      if($totalItems == 2 )
      {
        $list=7;
      }
      if($totalItems == 1)
      {
        $list=9;
      }
      for($i=0;$i<$list;$i++)
      {

  ?>
  
  <tr height="21">
    <td height="21" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center" ></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
    <td style="border-right:1px solid black;"><div align="center"></div></td>
  </tr>
<?php } ?>


<?php 

if($invDetails[0]['c_type'] == 'IGST')
{
?>
  
  <tr height="22">
    <td height="22" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <em><strong><?= "IGST&nbsp; (".$invDetails[0]['taxrate']." % )".""; ?></strong></em></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center"><b><?= number_format($invDetails[0]['taxamount'],2);  ?></b></div>
    <div align="center"></div></td>
  </tr>
<?php } ?>

<?php 

 if($invDetails[0]['c_type'] == 'Loc')
   {
?>
 <tr height="22">
    <td height="22" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <em><strong><?= "CGST&nbsp;(" . ($invDetails[0]['taxrate'] / 2) . " %)" . ""; ?>
</strong></em></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;"></td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"><div align="center"><?= number_format($invDetails[0]['taxamount']/2,2); ?> </div>
      <div align="center"></div></td></tr>
  <tr height="20">
    <td height="20" style="border-left:1px solid black;border-right:1px solid black;">&nbsp;</td>
    <td colspan="2" style="border-right:1px solid black;"><span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><strong><?= "SGST&nbsp;(" . ($invDetails[0]['taxrate'] / 2) . " %)" . ""; ?>
</strong></em></span></td>

    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;">&nbsp;</td>
    <td style="border-right:1px solid black;"> <div align="center"><?= number_format($invDetails[0]['taxamount']/2,2); ?> </div></td></tr> 
<?php } ?>

  <tr height="20">
    <td height="20" style="border:1px solid black;border-top:0px;">&nbsp;</td>
    <td colspan="2" id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br">&nbsp;</td>
    <td id="br"><div align="center"></div></td>
  </tr>
<?php endif; ?>

  <tr height="22">
    <td height="22" style="border:1px solid black;border-top:0px ">&nbsp;</td>
    <td colspan="2" id="br"> <div align="right" style="padding-right:4px;">
      <strong>Total</strong></div></td>
    <td id="br">&nbsp;</td>
    
    <td id="br"><div align="center"><?= number_format($totalItems,2); ?></div></td>
    <td id="br">&nbsp;</td>
    <td id="br"><div align="center">No</div></td>
    <td id="br"><div align="center"><b><?= number_format($invDetails[0]['totalamount'],2); ?></b></div></td>
  </tr>
  <tr height="22">
    <td colspan="7" height="22" style="border-left:1px solid black;">Amount Chargeable    (in words):</td>
    <td style="border-right:1px solid black;"><div align="center">E.&amp; O.E.</div></td>
  </tr>
  <tr height="27">
    <td colspan="8" height="27" style="border:1px solid black;border-top:0px;"><strong>Indian Rupees
      <?php echo digtoval($invDetails[0]['totalamount']); ?>  Only</strong>&nbsp;</td>
  </tr>

<?php if($invDetails[0]['c_type'] == 'IGST')
{
?>
  <tr height="20">
    <td colspan="3" rowspan="2" height="30" style="border:1px solid black;border-top:0px;"><div align="center">HSN /SAC</div></td>
    <td width="93" height="30" rowspan="2" id="br"><div align="center" style="padding-right:2px">Taxable Value</div></td>
    <td colspan="2" id="br">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Integrated Tax</td>
    <td colspan="2" style="border-right:1px solid black;"><div align="center">Total&nbsp;</div></td>
  </tr>
  <tr height="15">
    <td height="20" id="br">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rate&nbsp;</td>
    <td height="20" id="br"><div align="center">Amount</div></td>
    <td height="20" colspan="3" id="br" ><div align="center">Amount</div></td>
  </tr>
  <tr height="29">
    <td colspan="3" height="29" style="border:1px solid black;border-top:0px;"><div align="center"><?= $item['hsn']; ?></div></td>
    <td id="br"><div align="center"><?= number_format($invDetails[0]['subtotal'],2); ?></div></td>
    <td id="br"><div align="center"><?= $invDetails[0]['taxrate']." % ".""?></div></td>
    <td id="br"><div align="center"><?= number_format($invDetails[0]['taxamount'],2);  ?></div></td>
    <td colspan="2" id="br"><div align="center"><?= number_format($invDetails[0]['totalamount'],2);  ?></div></td>
  </tr>
  <tr height="24">
    <td colspan="3" height="24" style="border:1px solid black;border-top:0px;"><div align="center"><strong>Total</strong></div></td>
    <td id="br"><div align="center"><strong><?= number_format($invDetails[0]['subtotal'],2); ?></strong></div></td>
    <td id="br"><div align="center"></div></td>
    <td id="br"><div align="center"><strong><?= number_format($invDetails[0]['taxamount'],2);  ?></strong></div></td>
    <td colspan="2" id="br"><div align="center"><strong><?= number_format($invDetails[0]['totalamount'],2);  ?></strong></div></td>
  </tr>
<?php } ?>

<?php 
if($invDetails[0]['c_type'] == 'Loc')
{
?>
<tr height="20">
    <td colspan="2" rowspan="2" height="45" style="border:1px solid black;border-top:0px;" ><div align="center">HSN /SAC</div></td>
    <td rowspan="2" width="115" style="border-right:1px solid black;border-bottom:1px solid black;"><div align="center">Taxable    Value</div></td>
    <td colspan="2" style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Central Tax</div></td>
    <td colspan="2" style="border-bottom:1px solid black;border-right:1px solid black;"  ><div align="center">State Tax</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Total&nbsp;</div></td>
  </tr>

  <tr height="25">
    <td height="25" style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Rate</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Amount</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Rate</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Amount</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">Tax</div></td>
  </tr>
  <tr height="25">
    <td colspan="2" height="25" style="border:1px solid black; border-top:0px; " ><div align="center"><?= $item['hsn'];  ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
    <?= number_format($invDetails[0]['subtotal'],2); ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
    <?= number_format(($invDetails[0]['taxrate'] / 2),2) . " %" . ""; ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
    <?= number_format($invDetails[0]['taxamount'] / 2, 2); ?></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
      <?= number_format(($invDetails[0]['taxrate'] / 2),2) . " %" . ""; ?>
    </div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
    <?= number_format($invDetails[0]['taxamount'] / 2, 2); ?>
</div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
      <p><?= number_format($invDetails[0]['taxamount'],2); ?></p>
      </div></td>
  </tr>

  <tr height="24">
    <td colspan="2" height="24" style="border:1px solid black;border-top:0px;"  >
    <div align="center"><strong>Total</strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" >
    <div align="center"><strong><?= number_format($invDetails[0]['subtotal'],2); ?></strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;width: 83px;" >
    <div align="center" ><strong><?= number_format($invDetails[0]['taxamount'] / 2, 2); ?>
    </strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center">
    </div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;width: 83px;" ><div align="center"><strong>
    <?= number_format($invDetails[0]['taxamount'] / 2, 2); ?>
   </strong></div></td>
    <td style="border-bottom:1px solid black;border-right:1px solid black;" ><div align="center"><strong><?= number_format($invDetails[0]['taxamount'],2);?></strong></div></td>
  </tr>
  <tr height="34">
    <td colspan="8" height="27" style="border:1px solid black;border-top:0px;"><strong>Tax Amount (in words) :&nbsp; Indian Rupees 
     <?php echo digtoval($invDetails[0]['taxamount']); ?> Only&nbsp;</strong></td>
  </tr>
<?php } ?>

<?php 
 if($invDetails[0]['c_type'] == 'IGST')
{
?>

  <tr height="34">
    <td colspan="8" height="27" style="border:1px solid black;border-top:0px;">Tax Amount (in words) :&nbsp; <strong>Indian Rupees <?php echo digtoval($invDetails[0]['taxamount']); ?> Only&nbsp;</strong></td>
  </tr>
<?php } ?>



   <tr height="15">
    <td colspan="8" height="20" id="lr">&nbsp;</td>
  </tr>

  <!-- <?php
//foreach ($bankDetails as $bank) {
  
    ?>  
   <tr height="20">
    <td colspan="8" height="20" id="lr">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo "Bank Details"; ?></td>
  </tr>
   <tr height="20">
    <td colspan="8" height="20" id="lr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo "Bank Name: " . $bank['bname'] . "<br>"; ?></td>
  </tr>
  
  
  <tr height="19">
    <td colspan="8" height="19" id="lr">Proprietorship's PAN :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php //echo "A/C No: " . $bank['ac'] . "<br>"; ?></td>
  </tr>
  <tr height="20">
    <td colspan="8" height="20" id="lr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<?php //echo "IFSC Code: " . $bank['ifsc']; ?> &amp; <?php //echo "Branch: " . $bank['branch'] . "<br>"; ?></td>
  </tr>
  <?php //} ?> -->
  <tr height="20">
    <td colspan="8" height="20" id="lr"><u>Declaration&nbsp;&nbsp;</u></td>
  </tr>
  
  <tr height="24">
    <td height="24" colspan="4" style="border-left:1px solid black;">We    declare that this invoice shows the actual price of the&nbsp;</td>
    <td colspan="4" style="border:1px solid black;border-bottom:0px;"><div align="right" style="padding-right:10px;"><strong>for <?= $invDetails[0]['c_name']; ?></strong></div></td>
  </tr>
  <tr height="29">
    <td height="29" colspan="3" style="border-left:1px solid black;">goods described and that all particulars are true and correct.</td>
    <td>&nbsp;</td>
    <td colspan="4" id="lr"><div align="right"></div></td>
  </tr>
  <tr height="19">
    <td height="19" colspan="4" style="border-left:1px solid black; border-bottom:1px solid black;" >&nbsp;</td>
    <td colspan="4" style="border:1px solid black;border-top: 0px; padding-right:10px; "><div align="right">Authorised    Signatory</div></td>
  </tr>
  <tr height="5">
    <td colspan="8" height="5"><div align="center"></div></td>
  </tr>
  <tr height="20">
    <td height="20" colspan="8"><div align="center">This is a Computer    Generated Invoice</div></td>
  </tr>
  <!-- <tr height="20">
    <td height="20"></td>
    <td width="217"></td>
    <td width="101"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr> -->
</table>
</page>


<script >
  var base_url = "<?= base_url(); ?>";
</script>
<script>
$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    let orderid = urlParams.get('orderid') || window.location.pathname.split('/').pop();

    console.log('orderid:', orderid); // Debugging: Check if orderid is correct
    if (!orderid) {
        alert('Order ID is missing!');
        return;
    }

    // AJAX request to fetch the print quote page
    $.ajax({
        url: base_url + '/purchaseinv/printpurchaseinv', // URL for the server endpoint
        type: 'GET',
        data: { orderid: orderid }, // Pass order ID as query parameter
        dataType: 'html', // Expecting HTML response
        success: function (response) {
            console.log('Response:', response); // Debugging: Check the response
            $('#contentContainer').html(response); // Inject response into a container
        },
        error: function (xhr, status, error) {
            console.error('Error fetching quote info:', error);
            alert('Failed to fetch the quote. Please try again.');
        }
    });
});
</script>

</body>

</html>
<?php 
// }
// else{
//   echo "Invoice Not Generated";
// }
?>