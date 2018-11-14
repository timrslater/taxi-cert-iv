<?php
session_start();
include('includes/database.php');
$page_title = "Taxi User Login";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //handle login here
}
?>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navigation.php')?>
        <div class="container">
               <div class="row">
                    <form id="login-form" method="post" action="login.php" class="col-md-4 offset-md-4">
                        <h1>Login</h1>
                        <div class="form-group">
                           <label for="email">Email</label>
                           <input 
                           class="form-control"
                           type="email"
                           id="email"
                           name="customer_email"
                           placeholder="your email">
                       </div>
                       <div class="form-group">
                           <label for="password">Password</label>
                           <input 
                           class="form-control"
                           type="password"
                           id="password"
                           name="password"
                           placeholder="your password">
                       </div>
                       <div class="text-center">
                           <button class="btn btn-success" type="submit">Login</button>
                       </div>
                    </form>
               </div>
        </div>
    </body>
</html>