<?php include('partials-front/menu.php')?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //get all actived food from database
                $stmt = $con->prepare("SELECT * from food WHERE active = 1 ");
                $stmt->execute();
                $foods = $stmt->fetchAll();
                foreach($foods as $food){?>

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
</html>