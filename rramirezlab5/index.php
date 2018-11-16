<?php
   include 'dbConnection.php'; 
   
   function displayCategories(){
        global $conn;
        
        $sql = "SELECT catId, catName FROM `om_category` ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //print_r($records);
        
        foreach ($records as $record) {
            
            echo "<option value='".$record["catId"]."' >" . $record["catName"] . "</option>";
            
        }
        
    }
    
    function displaySearchResults(){
        global $conn;
        
        if (isset($_GET['searchForm'])) { //checks whether user has submitted the form
            
            echo "<h3>Products Found: </h3>"; 
            
            //following sql works but it DOES NOT prevent SQL Injection
            //$sql = "SELECT * FROM om_product WHERE 1
            //       AND productName LIKE '%".$_GET['product']."%'";
            
            //Query below prevents SQL Injection
            
            $namedParameters = array();
            
            $sql = "SELECT * FROM om_product WHERE 1";
            
            if (!empty($_GET['product'])) { //checks whether user has typed something in the "Product" text box
                 $sql .=  " AND productName LIKE :productName OR productDescription LIKE :productName";
                 
                 $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
            }
                  
                  
             if (!empty($_GET['category'])) { //checks whether user has typed something in the "Product" text box
                 $sql .=  " AND catId = :categoryId";
                 $namedParameters[":categoryId"] =  $_GET['category'];
             }    
            
             if (!empty($_GET['priceFrom'])) { //checks whether user has typed something in the "Product" text box
                 $sql .=  " AND price >= :priceFrom";
                 $namedParameters[":priceFrom"] =  $_GET['priceFrom'];
             }
             
            if (!empty($_GET['priceTo'])) { //checks whether user has typed something in the "Product" text box
                 $sql .=  " AND price <= :priceTo";
                 $namedParameters[":priceTo"] =  $_GET['priceTo'];
             }
            
             if (isset($_GET['orderBy'])) {
                 
                 if ($_GET['orderBy'] == "price") {
                     
                     $sql .= " ORDER BY price";
                     
                 } else {
                     
                      $sql .= " ORDER BY productName";
                 }
                 
                 
             }
            //echo $sql; //for debugging purposes
            
             $stmt = $conn->prepare($sql);
             $stmt->execute($namedParameters);
             $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            foreach ($records as $record) {
            
                 echo "<a href=\"purchaseHistory.php?productId=".$record["productId"]. "\"> History </a>";
                 echo  $record["productName"] . " " . $record["productDescription"] . " $" . $record["price"] . "<br /><br />";
            
            }
        }
        
    }
<<<<<<< HEAD
    
=======
	function displaySearchResults(){
		global $conn;
		
		if (isset($_GET['searchForm'])){//checks for user submit
			echo "<h3>Products Found: </h3>";
			//prevents sql injection
			$namedParameters = array();
			
			$sql = "SELECT * FROM om_product WHERE 1";
			
			if(!empty($_GET['product'])){
				 $sql .=  " AND productName LIKE :productName OR productDescription LIKE :productName";
                 $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
			}
			if(!empty($_GET['category'])){
				$sql .= " AND catId = :categoryId";
				$namedParameters[":categoryId"]= $_GET['category'];
			}
			if(!empty($_GET['priceFrom'])){
				$sql .= " AND price >= :priceFrom";
				$namedParameters[":priceFrom"] = $_GET['priceFrom'];
			}
			if(!empty($_GET['priceTo'])){
				$sql .= " AND price <= :priceTo";
				$namedParameters[":priceTo"] = $_GET['priceTo'];
			}
			if(isset($_GET['orderBy'])){
				if($_GET['orderBy'] == "price"){
					$sql .= " ORDER BY price";
				}else{
					$sql .= " ORDER BY productName";
				}
			}	
			$stmt = $conn->prepare($sql);
            $stmt->execute($namedParameters); // We NEED to include $namedParameters here
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($records as $record){
				echo "<a href='purchaseHistory.php?productId=".$record['productId']. "'> History </a>";
				echo $record["productName"]." ".$record["productDescription"]. " $" . $record["price"]."<br/><br/>";
			}
		}
	}	
>>>>>>> 759cb6121d29a9eb1c48bd10f8cbb20b65488633
?>

<!DOCTYPE html>
<html>
<<<<<<< HEAD
    <head>
        <title> OtterMart Product Search </title>
        <style type="text/css">
             @import url("css/style.css");
        </style>
    </head>
    <body>

        <h1>  OtterMart Product Search </h1>
        
        <form>
            
            Product: <input type="text" name="product" /><br />
            
            Category: 
                <select name="category">
                    <option value=""> Select One </option>
                    <?=displayCategories()?>
                </select>
            <br />
            
            Price:  From <input type="text" name="priceFrom" size="7"/>
                    To   <input type="text" name="priceTo" size="7"/>
                    
            <br />
            
             Order result by:<br />
             
             <input type="radio" name="orderBy" value="price"/> Price <br />
             <input type="radio" name="orderBy" value="name"/> Name
             
             <br />
             <input type="submit" value="Search" name="searchForm" />
             
        </form>
        
        <br />
        <hr>
        
        <?= displaySearchResults() ?>
=======
	<head>
		<title>OtterMart Product Search</title>
		<link rel="stylesheet" href="css/styles.css" type="text/css"/>
	</head>
	<body>
			<h1> OtterMart Product Search </h1>
			<div class="row">
			<form>
				<div class="column">
				<label>Product:</label><br>				
				<input type="text" name ="product"/>
				<br/><br/>
				<label>Category:</label> 
					<select name="category">
						<option value="">Select One</option>
						<?=displayCategories()?>
					</select>
				<br/><br/>
				<label>Price:</label><br> 
				<label>From</label>
				<input type="text" name="priceFrom" size="7"/>
				<label>To</label>  
				<input type="text" name="priceTo" size="7"/>
				<br/>
				<label>Order result by:</label>
				<br/>
				<input type="radio" name="orderBy" value="price"/> Price <br/>
				<input type="radio" name="orderBy" value="name"/> Name <br/>
				<br/><br/>
				<input type="submit" value="Search" name="searchForm">
				</div>
			</form>
			</div>
			<br/>
		
		<hr>
		<?=displaySearchResults()?>
>>>>>>> 759cb6121d29a9eb1c48bd10f8cbb20b65488633
		</div>
		<!-- Footer Info -->
        <footer>
            <hr>CST 336 2018&copy; Ramirez <br/>
            <strong>Disclaimer:</strong> The information in this webpage is used for academic purposes only.<br/>
            <img src="img/csumb.jpg" alt="Logo of our Mascot"/>
        </footer>
	</body>
</html>