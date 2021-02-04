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

    <?php
        if(isset($_SESSION['order'])){

            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }

    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //get all actived and featured categories from database
                $stmt = $con->prepare("SELECT * from category WHERE featured = 1 AND active = 1 order by id DESC LIMIT 3");
                $stmt->execute();
                $cats = $stmt->fetchAll();
                foreach($cats as $cat){?>

                    <a href="<?php echo SITEURL. "category-foods.php?id=" . $cat['id']?>">
                    <div class="box-3 float-container">
                        <img src="<?php echo SITEURL . 'images/category/' . ((!empty($cat['image_name']))? $cat['image_name'] : "default_cat.png") ;?>" class="img-responsive img-curve">
                        <h3 class="float-text text-white"><?php echo $cat['title']?></h3>
                    </div>
                    </a>                    
                    <?php
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //get all actived and featured food from database
                $stmt = $con->prepare("SELECT * from food WHERE featured = 1 AND active = 1 order by id DESC LIMIT 6");
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

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


<?php include('partials-front/footer.php')?>