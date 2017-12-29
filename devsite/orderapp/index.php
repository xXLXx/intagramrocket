<?php


require 'database_config.php';

if(isset($_GET['export']))
{
      session_start();
      $shopDomain = $_SESSION['shop'];

      // output headers so that the file is downloaded rather than displayed
      header('Content-type: text/csv');
      header('Content-Disposition: attachment; filename="file.csv"');
       
      // do not cache the file
      header('Pragma: no-cache');
      header('Expires: 0');
       
      // create a file pointer connected to the output stream
      $file = fopen('php://output', 'w');
       
      // send the column headers
      fputcsv($file, array('Invoice Date', 'Invoice Number', 'Invoice Status', 'Customer', 'Due Date', 'PurchaseOrder', 'Template Name', 'Currency Code', 'Exchange Rate', 'Item Name', 'Item Desc', 'Quantity', 'Item Price', 'Is Inclusive Tax', 'Discount(%)', 'Item Tax1', 'Item Tax1 %', 'Item Tax1 Type', 'Item Tax2', 'Item Tax2 %', 'Item Tax2 Type', 'Notes', 'Terms & Conditions', 'PayPal', 'Authorize.Net', 'Google Checkout'));


       
       $sql="SELECT * from orderDetails where shopdomain='$shopDomain'";
       

        if ($result=mysqli_query($newCon,$sql))
        {
        // Fetch one and one row
        while ($row=mysqli_fetch_row($result))
          {
              $id=$row[0];
              $date1=$row[2];
              $date2=$row[3];
              $date3=$row[4];
              $date4=$row[5];
              $date5=$row[11];
              $date6=$row[12];
              $date7=$row[13];
              $date8=$row[14];
              $date9=$row[15];
              $date10=$row[16];
              $status=$row[23];
              $create_date=$row[17];
              $order_id=$row[7];
              $customer_name=$row[9].' '.$row[10];
              $item_name=$row[19];
              $inv_date=date("Y-m-d", strtotime($create_date));
              $po_order='PO-'.$order_id;

              $Currency=$row[18];
              $quantity=$row[20];
              $price=$row[21];

              if($date1!='')
              {
                $due_date=$date1;
              }
              else if($date2!='')
              {
                $due_date=$date2;
              }
              else if($date3!='')
              {
                $due_date=$date3;
              }
              else if($date4!='')
              {
                $due_date=$date4;
              }
              else if($date5!='')
              {
                $due_date=$date5;
              }
              else if($date6!='')
              {
                $due_date=$date6;
              }
              else if($date7!='')
              {
                $due_date=$date7;
              }
              else if($date8!='')
              {
                $due_date=$date8;
              }
              else if($date9!='')
              {
                $due_date=$date9;
              }
              else
              {
                $due_date=$date10;
              }
              $due_date=date("Y-m-d", strtotime($due_date));

              $fields = array($inv_date,$order_id,'Draft',$customer_name,$due_date,$po_order,'Classic',$Currency,'',$item_name,'',$quantity,$price,'TRUE','','','','','','','','Thanks for your business.','Terms and Condition','','false','false');



              fputcsv($file, $fields);


          }
       
       }
       
      exit();


}
require_once 'header.php';
require 'keys.php';
require 'shopify.php';

if(!$_SESSION['shop'])
{
   header('Location: login.php');
}

$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], $api_key, $secret);

$_DOMAIN=$_SESSION['shop'];
$baseURL = 'https://instagramrocket.com';



$shopDomain = $_SESSION['shop'];
$shopToken = $_SESSION['token'];

if(isset($_SESSION['shop']))
{ 
  $sql="SELECT * from shopDetails where shopDomain='$shopDomain' ";
  $qex=mysqli_query($newCon,$sql);
  $num_rows=mysqli_num_rows($qex);
  
  if($num_rows==0)
  { 
    $sql="INSERT INTO shopDetails(shopDomain,shopToken)VALUES('".$shopDomain."','".$shopToken."')";
    $qex=mysqli_query($newCon,$sql); 
  }
  else
  {
    $sql="UPDATE shopDetails set shopToken='".$shopToken."' where shopDomain='".$shopDomain."' ";
    $qex=mysqli_query($newCon,$sql);
  }
  if ($qex) {
    ?>


<?php 

if(isset($_GET['updatedate']))
{

           $id=$_GET['id'];
           $date1=$_GET['date1'];
           $date2=$_GET['date2'];
           $date3=$_GET['date3'];
           $date4=$_GET['date4'];
           $date5=$_GET['date5'];
           $date6=$_GET['date6'];
           $date7=$_GET['date7'];
           $date8=$_GET['date8'];
           $date9=$_GET['date9'];
           $date10=$_GET['date10'];
           $status=$_GET['status'];  

    $sql="UPDATE orderDetails set date1='".$date1."',date2='".$date2."',date3='".$date3."',date4='".$date4."',date5='".$date5."',date6='".$date6."',date7='".$date7."',date8='".$date8."',date9='".$date9."',date10='".$date10."',status='".$status."' where id=".$id."";
    $qex=mysqli_query($newCon,$sql);

    header('Location: index.php');

}
else if(isset($_GET['edit']))
{
        $id=$_GET['edit'];
        $sql="SELECT * from orderDetails where id='$id' ";
       

        if ($result=mysqli_query($newCon,$sql))
        {
        // Fetch one and one row
        while ($row=mysqli_fetch_row($result))
          {
              $id=$row[0];
              $date1=$row[2];
              $date2=$row[3];
              $date3=$row[4];
              $date4=$row[5];
              $date5=$row[11];
              $date6=$row[12];
              $date7=$row[13];
              $date8=$row[14];
              $date9=$row[15];
              $date10=$row[16];
              $status=$row[23];
          }
       
       }


       ?>


 <h1>Updates Dates</h1>
 <div class="seprator"></div> 
       <form action="" method="get">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="text" name="date1" value="<?php echo $date1; ?>" placeholder="Box1">
              <input type="text" name="date2" value="<?php echo $date2; ?>" placeholder="Box2">
              <input type="text" name="date3" value="<?php echo $date3; ?>" placeholder="Box3">
              <input type="text" name="date4" value="<?php echo $date4; ?>" placeholder="Box4">
              <input type="text" name="date5" value="<?php echo $date5; ?>" placeholder="Box5">
              <input type="text" name="date6" value="<?php echo $date6; ?>" placeholder="Box6">
              <input type="text" name="date7" value="<?php echo $date7; ?>" placeholder="Box7">
              <input type="text" name="date8" value="<?php echo $date8; ?>" placeholder="Box8">
              <input type="text" name="date9" value="<?php echo $date9; ?>" placeholder="Box9">
              <input type="text" name="date10" value="<?php echo $date10; ?>" placeholder="Box10">
              <select name="status">
                  <option <?php if($status==0){ echo 'checked'; } ?> value="0">Pending</option>
                  <option <?php if($status==1){ echo 'checked'; } ?> value="1">Done</option>
              </select>
              <input type="submit" value="save" name="updatedate">

       </form>


       <?php




}
else
{

?>


  <style>

body{
    margin: 0;
}
h1 {
  font-family: -apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif;
  font-size: 24px;
  margin: 50px 0 5px;
  text-align: center;
}
.popup:before {
  content: "";
  height: 100%;
  width: 100%;
  position: absolute;
  background-color: rgba(0,0,0,0.6);
}

 .popup {
  position: fixed;
  top: 0;
  width: 100%;
  height: 100%;
}

 .popup table {
  width: 100%;
  background-color: #fff;
  margin: 0 auto;
  position: relative;
  left: 0;
  right: 0;
  top: 0;
  z-index: 9999;
  height: auto;
  padding: 0px;
  border-radius: 5px;
  overflow: visible;
  display: block;
}
.popup > table tr:first-child td {
  border: medium none;
}
.seprator {
  border-top: 1px solid;
  margin: 0 auto;
  padding: 0 0 30px;
  width: 17%;
}
.pricing-tables table tbody tr:first-child {
  background: rgba(0, 0, 0, 0) linear-gradient( bottom , #040404 0%, #484848 100%) repeat scroll 0 0;
  background: -moz-linear-gradient( bottom , #040404 0%, #484848 100%) repeat scroll 0 0;
  background: -webkit-linear-gradient( bottom , #040404 0%, #484848 100%) repeat scroll 0 0;
  border-radius: 3px;
  box-shadow: 0 1px 0 0 #efefef;
  color: #ffffff;
  font-weight: 600;
  margin-top: 5px;
  outline: medium none;
  padding: 8px 20px;
  text-decoration: none;
}
.pricing-tables > table {
  background-color: rgba(0, 0, 0, 0);
  border: medium none;
  border-collapse: collapse;
  box-shadow: 0 1px 10px rgba(0, 0, 0, 0.7);
  font-family: -apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif;
  margin: 0 auto;
}
.pricing-tables table tbody tr td {
  border-color: -moz-use-text-color #828282 #828282;
  border-style: none solid solid;
  border-width: medium 1px 1px;
  font-size: 14px;
  line-height: normal;
  padding: 10px 20px;
  text-align: center;
}
.pricing-tables table tbody tr {
  background-color: #ffffff;
}

.pricing-tables table tbody tr td a {
  background: rgba(0, 0, 0, 0) linear-gradient(to top, #0089cb 0%, #0278be 100%) repeat scroll 0 0;
  border-radius: 3px;
  color: #ffffff;
  padding: 5px 20px;
  text-decoration: none;
}
.popup table tr td {
  border: 1px solid #828282;
  border-collapse: collapse;
  font-size: 14px;
  line-height: normal;
  padding: 10px 20px;
  text-align: center;
  font-family: -apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif;  
}
.popup .cancel_button button {
  background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #0089cb 0%, #0278be 100%) repeat scroll 0 0;
  border: medium none;
  border-radius: 50px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.7);
  color: #ffffff;
  cursor: pointer;
  font-family: -apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif;
  font-weight: 600;
  outline: medium none;
  padding: 1px 5px;
  position: absolute;
  right: 7px;
  text-decoration: none;
  top: 5px;
}
.popup_inner {
  background: #ffffff none repeat scroll 0 0;
  border-radius: 5px;
  margin: 0 auto;
  max-width: 615px;
  padding: 50px 20px 20px;
  position: relative;
  top: 20%;
  width: 100%;
}
.table-responsive {
  overflow-x: scroll;
  overflow-y: hidden;
}
.pricing-tables {
  padding: 0 20px 20px;
}
#myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}

#myTable {
    border-collapse: collapse; /* Collapse borders */
    width: 100%; /* Full-width */
    border: 1px solid #ddd; /* Add a grey border */
    font-size: 18px; /* Increase font-size */
}

#myTable th, #myTable td {
    text-align: left; /* Left-align text */
    padding: 12px; /* Add padding */
}

#myTable tr {
    /* Add a bottom border to all table rows */
    border-bottom: 1px solid #ddd; 
}

#myTable tr.header, #myTable tr:hover {
    /* Add a grey background color to the table header and on hover */
    background-color: #f1f1f1;
}
</style> 

 <h1>All Orders</h1>
 <div class="seprator"></div>
 <div class="pricing-tables">
                <!-- <ul class="main"> -->
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for customer name.." title="Type in a name">
                <form action="" method="get">
                    <input type="submit" name="export" value="Export">
                </form>
                <table border="0" cellspacing="0" cellpadding="0" id="myTable">
                  <tr class="header"><th>Id</th><th>Order Id</th><th>First name</th><th>Last name</th><th>Box 1</th><th>Box 2</th><th>Box 3</th><th>Box 4</th><th>Box 5</th><th>Box 6</th><th>Box 7</th><th>Box 8</th><th>Box 9</th><th>Box 10</th><th>Schedule</th><th>Created</th><th>Status</th><th>Action</th></tr>

                  <?php 
                  $query = "SELECT * FROM orderDetails where shopdomain='$shopDomain' ORDER by id";

                  if ($result = $newCon->query($query)) {

                      /* fetch associative array */
                      while ($row = $result->fetch_assoc()) {
                        ?>
                           <tr>
                      <td><?php echo $row["id"]; ?></td>
                       <td><?php echo $row["order_id"]; ?></td>
                           <td><?php echo $row["first_name"]; ?></td>
                              <td><?php echo $row["last_name"]; ?></td>
                        <td><?php if($row["date1"]!=''){ echo date("d/m/Y", strtotime($row["date1"])); } ?></td>
                         <td><?php if($row["date2"]!=''){ echo date("d/m/Y", strtotime($row["date2"])); } ?></td>
                          <td><?php if($row["date3"]!=''){ echo date("d/m/Y", strtotime($row["date3"])); } ?></td>
                           <td><?php if($row["date4"]!=''){  echo date("d/m/Y", strtotime($row["date4"])); } ?></td>
                           <td><?php if($row["date5"]!=''){  echo date("d/m/Y", strtotime($row["date5"])); } ?></td>
                           <td><?php if($row["date6"]!=''){  echo date("d/m/Y", strtotime($row["date6"])); } ?></td>
                           <td><?php if($row["date7"]!=''){  echo date("d/m/Y", strtotime($row["date7"])); } ?></td>
                           <td><?php if($row["date8"]!=''){  echo date("d/m/Y", strtotime($row["date8"])); } ?></td>
                           <td><?php if($row["date9"]!=''){  echo date("d/m/Y", strtotime($row["date9"])); } ?></td>
                           <td><?php if($row["date10"]!=''){  echo date("d/m/Y", strtotime($row["date10"])); } ?></td>
                            <td><?php echo $row["schedule"]; ?></td>
                    
                              <td><?php echo date("d/m/Y", strtotime($row["created_date"])); ?></td>
                             
                               <td><?php if($row["status"]==0){ echo 'Pending'; }else{ echo 'Done'; } ?></td>
                                <td><a href="?edit=<?php echo $row["id"]; ?>">Edit</a></td>
                    </tr>
                          
                      
                          <?php
                      }

                  }



                  ?>

                         </table>
 <script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
                   
                               
</div>

<?php
}
?>

    <?php
  }
  else
  {
    //echo "error";
  }
  
}


$url ='/admin/webhooks.json';
$odrerCreated=$sc->call('GET','/admin/webhooks.json?address='.$baseURL.'/orderapp/webhooks/ordercreated.php');

$meta=array(
 "webhook"=>array(
       "topic"=> "orders/create",
       "address"=> $baseURL."/orderapp/webhooks/ordercreated.php",
        "format"=>"json"
  )
  );
if (empty($odrerCreated)) {      
      
    $sc->call('POST', $url,$meta);
}

$data=array('role'=>'main');
$themes=$sc->call('GET','/admin/themes.json',$data);



  $themes = json_decode(json_encode($themes), True);

    

  foreach ($themes as $value) {

    if($value['role']=='main')
    {
      $themeID=$value['id'];

   

      $filename = "/home/instag8/public_html/orderapp/webhooks/productproperties.txt";
      $handle = fopen($filename, "r");
      $contents = fread($handle, filesize($filename));
      fclose($handle);

      $view=$contents;




      $datas=array('asset'=>array('key'=>'snippets/productproperties.liquid','value'=>$view));
    
      //$test=$sc->call('PUT','/admin/themes/' . $themeID . '/assets.json', $datas);
    
    }

  }


?>

<body>
<?php

?>

</body>
</html>


<script type="text/javascript">
    ShopifyApp.init({
      apiKey: '<?php echo $api_key; ?>',
      shopOrigin:"<?php echo $shopURL; ?>",

      debug: true
    });
</script>
<script type="text/javascript">
  ShopifyApp.ready(function(){
    ShopifyApp.Bar.initialize({
      
      title: 'Silhouettes',
          callback: function(){ 
            ShopifyApp.Bar.loadingOff();
            
          }
    });
  });
  </script>

