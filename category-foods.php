<?php include('partials-front/menu.php')?>

<?php
    // check if any Get RequestMethod
    if($_SERVER['REQUEST_METHOD'] === 'GET' ){

        //get id from the request
        if(isset($_GET['id'])){
            
            $id = $_GET['id'];    
            
            //query to get category title by id
            $stmt = $con->prepare("SELECT title FROM category WHERE id=?");
            $stmt->execute(array($id));
            $cat = $stmt->fetch();
            
        }
        else{
            //redirect to home page
            header('location:'. SITEURL);
        }
    }
?>




    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $cat['title']?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

            //query to get category
            $stmt = $con->prepare("SELECT * FROM food WHERE active = 1 AND category_id = ? ");
            $stmt->execute(array($id));
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