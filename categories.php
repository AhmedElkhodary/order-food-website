<?php include('partials-front/menu.php')?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                //get all actived categories from database
                $stmt = $con->prepare("SELECT * from category WHERE  active = 1 ");
                $stmt->execute();
                $cats = $stmt->fetchAll();
                foreach($cats as $cat){?>

                    <a href="category-foods.html">
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


<?php include('partials-front/footer.php')?>