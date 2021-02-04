<?php include('partials-front/menu.php')?>


<?php

    // check if any Get RequestMethod
    if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){

        //get id from the request
        $id = $_GET['id'];    
            
        //query to get food details by id
        $stmt = $con->prepare("SELECT * FROM food WHERE id=?");
        $stmt->execute(array($id));
        $food = $stmt->fetch();
    }    
    else{
        //redirect to home page
        header('location:'. SITEURL);
        
    }
?>




    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">

                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <img src="<?php echo SITEURL . 'images/food/' . ((!empty($food['image_name']))? $food['image_name'] : "default_food.png") ;?>" class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $food['title']?></h3>
                        <p class="food-price"><?php echo $food['price'];?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>   
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <!--hidden input-->
                    <input type="hidden" name="food" value="<?php echo $food['title'] ?>">
                    <input type="hidden" name="price" value="<?php echo $food['price'] ?>">
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>
            </form>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php
    //check if there post request
    if(isset($_POST['submit'])){
                    
        //get data from form
        $qty      = $_POST['qty'];
        $cus_name = $_POST['full-name'];
        $contact  = $_POST['contact'];
        $email    = $_POST['email'];
        $address  = $_POST['address'];

        //hidden 
        $food  =    $_POST['food'];
        $price =    $_POST['price'];

        $total = $price * $qty;
        $order_date = date("Y-m-d h:i:s a");
        $status = "ordered"; 


        //query to save order in database
        $stmt = $con->prepare("INSERT INTO t_order(food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address)
                               VALUES(:zfood, :zprice, :zqty, :ztotal, :zorder_date, :zstatus, :zcustomer_name, :zcustomer_contact, :zcustomer_email, :zcustomer_address)
                            ");
        $stmt->execute(array(

            'zfood'             => $food,
            'zprice'            => $price,
            'zqty'              => $qty,
            'ztotal'            => $total,
            'zorder_date'       => $order_date,
            'zstatus'           => $status,
            'zcustomer_name'    => $cus_name,
            'zcustomer_contact' => $contact,
            'zcustomer_email'   => $email, 
            'zcustomer_address' => $address           
        ));

        if ($stmt == TRUE ){

            $_SESSION['order'] =  "<div class='msg'>Successfully Added Order</div>";
            header('location:' . SITEURL);
        }
        else{
            
            $_SESSION['order'] =  "<div class='msg'>Failed Add Order</div>";
            header('location;' . SITEURL);
        }
    }    
    else{
        header('location' . SITEURL);
    }    
?>


<?php include('partials-front/footer.php')?>


