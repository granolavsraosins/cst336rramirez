<?php
    $backgroundImage = "img/sea.jpg";
    include 'api/pixabayAPI.php';
    //API call goes here
    if(!empty($_GET['keyword'])){
        //print_r($_GET['keyword']);
        $imageURLs = getImageURLs($_GET['keyword'],$_GET[layout]);
        $backgroundImage = $imageURLs[array_rand($imageURLs)];
    }elseif(isset($_GET['category'])){
        $imageURLs = getImageURLs($_GET['category'],$_GET[layout]);
        $backgroundImage = $imageURLs[array_rand($imageURLs)];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Image Carousel</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        
        <style>
            @import url("/rramirezlab3/css/styles.css");
            body {
                background-image: url('<?=$backgroundImage?>');
            }
        </style>
    </head>
    
    <body>
        <br/>
        <!-- HTML Form -->
        <form>
            <input id="searchbar" type="text" name="keyword" placeholder="Keyword" value="<?=$_GET['keyword']?>">
            <!-- button for Horizontal layout -->
                <div>
                <input type="radio" id="lhorizontal" name='layout' value="horizontal">
                <label for="horizontal">Horizontal</label>
                <br>
                <!-- button for Vertical layout -->
                <input type="radio" id="lvertical" name="layout" value="vertical">
                <label for="vertical">Vertical</label>
                <br>
            </div>
            <select name="category">
                <option value="">Select One</option>
                <option>Forest</option>
                <option>Sky</option>
                <option>People</option>
                <option>Elephants</option>
                <option>Cars</option>
            </select>
            
            <input type="submit" value="Search"/>
        </form>
        
        <?php
            if(!isset($imageURLs)) {
                echo "<h2>Type a keyword to display a slideshow <br/> of random images from Pixabay.com</h2>";
            }else if (empty($_GET['keyword'])){
                echo "<h2> Please enter a keyword </h2>";
                
            }else {
        ?>
        
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width:500px">
          <!-- Indicators-->
          <ol class="carousel-indicators">
              <?php
                for($i = 0; $i < 7; ++$i) {
                    echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                    echo ($i == 0) ? " class='active'" : "";
                    echo "></li>";
                }
              ?>
          </ol>
          
          <!-- Wrapper for Images -->
          <div class="carousel-inner" role="listbox">
              <?php
                for($i = 0; $i < 7; ++$i) {
                    
                    // Ensures no duplicate pictures
                    do {
                        $randomIndex = rand(0, count($imageURLs));
                    } while(!isset($imageURLs[$randomIndex]));
                    
                    echo '<div class="item';
                    echo ($i == 0) ? " active" : "";
                    echo '">';
                    echo '<img src="' . $imageURLs[$randomIndex] . '" width=500px>';
                    echo "</div>";
                    unset($imageURLs[$randomIndex]);
                }
              ?>
            </div>
            
            
            <!-- Move Picture Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <?php
            } // Ends the 'else' statement
        ?>
        
        <br/>
        <br/>
        
        <!--Put Javascript APIs here b/c it could block the displays by going first-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>