<?php
include 'config.php';
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'user') {

    include 'header.php'; ?>
    <div class="product-cart-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-head">My Orders</h2>
                    <?php
                        $user = $_SESSION['user_id'];
                        $db = new Database();
                        $db->sql('SELECT order_products.product_id,order_products.order_id,order_products.total_amount,order_products.product_qty,order_products.delivery,order_products.product_user,order_products.order_date,products.featured_image,user.f_name,user.address,user.city, GROUP_CONCAT(DISTINCT products.product_title ORDER BY products.product_id SEPARATOR "$$") as product_titles,GROUP_CONCAT(DISTINCT products.featured_image ORDER BY products.product_id) as product_images,GROUP_CONCAT(DISTINCT products.product_price ORDER BY products.product_id) as product_prices FROM order_products LEFT JOIN products ON FIND_IN_SET(products.product_id,order_products.product_id) > 0
                     LEFT JOIN user ON order_products.product_user=user.user_id WHERE product_user = '.$user.' GROUP BY order_products.order_id ORDER BY order_products.order_id DESC');
                        $result = $db->getResult();
                        if(count($result) > 0){ ?>
                            <?php foreach($result as $row){  
                                    for($i=0;$i<count($row);$i++){
                                    ?>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="active">
                                        <th colspan="3"><h4><b>ORDER No. : <?php echo 'ODR00'.$row[$i]['order_id']; ?></b></h4></th>
                                    </tr>
                                    <?php
                                    $product_titles = array_filter(explode('$$',$row[$i]['product_titles']));
                                    $product_prices = array_filter(explode(',',$row[$i]['product_prices']));
                                    $product_qty = array_filter(explode(',',$row[$i]['product_qty']));
                                    $product_images = array_filter(explode(',',$row[$i]['product_images']));
                                        for($p=0;$p<count($product_qty);$p++){
                                    ?>
                                    <tr>
                                        <td>
                                            <img class="img-thumbnail" src="product-images/<?php echo $product_images[$p]; ?>" alt="" width="100px" />
                                        </td>
                                        <td>
                                            <span><b>Product Name :</b> <?php echo $product_titles[$p]; ?></span><br/>
                                            <span><b>Product Price :</b> <?php echo $cur_format.' '.$product_prices[$p]; ?></span><br/>
                                            <span><b>Quantity :</b> <?php echo $product_qty[$p]; ?></span><br/>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3" align="right"><b>Total Amount:  <?php echo $cur_format.' '.$row[$i]['total_amount']; ?></b></td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                            <?php } 
                                }?>
                        <?php    }else{ ?>
                                <div class="empty-result">
                        No Orders Found.
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php';

}else{
    header("Location: " . $hostname);
}
?>