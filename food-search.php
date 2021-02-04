<?php include('partials-front/menu.php')?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <?php

                // check if requestMethod is POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $search = $_POST['search'];
                    ?>
                    <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search;?>"</a></h2>
                    <?php
                }    
            ?>
     

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // query to select food  where foodTitle OR foodDescription LIKE Search word
                $stmt = $con->prepare("SELECT * FROM food WHERE active = 1 AND (title LIKE '%$search%' OR Description  LIKE '%$search%') ");
                $stmt->execute();
                $foods = $stmt->fetchAll();
                
                //Print the result 
                foreach ($foods as $food) {
                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <img src="<?php echo SITEURL . 'images/food/' . ((!empty($food['image_name']))? $food['image_name'] : "default_food.png") ;?>" class="img-responsive img-curve">
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $food['title']?></h4>
                            <p class="food-price">$<?php echo $food['price']?></p>
                            <p class="food-detail">
                                <?php echo $food['Description']?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL . 'order.php?id=' . $food['id'] ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>                    
                    <?php
                }
            ?>




            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php')?>