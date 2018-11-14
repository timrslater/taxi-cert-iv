<?php
session_start();
include('includes/database.php');
$page_title = "Register New User";

//PROCESS REGISTRATION FORM
$request_type= $_SERVER['REQUEST_METHOD'];
//This variable will return value of get (if page loaded normally) or post (if loaded via form)
if($request_type== 'POST'){
    //array to store errors
    $errors = array();
    $customer_name= $_POST['customer_name'];
    if( strlen( $customer_name) !== strlen( trim($customer_name))){
        $errors['customer_name'] = 'cannot contain leading or trailing spaces';
    }
    //echo "customer_name=$customer_name"; 
    $customer_email = $_POST['customer_email'];
    if(filter_var($customer_email, FILTER_VALIDATE_EMAIL) ==false){
        $errors['customer_email'] = 'please enter a valid email address';        
    }
    //echo "customer_email=$customer_email"; 
    $customer_mobile = $_POST['customer_mobile'];
    //echo "customer_mobile=$customer_mobile"; 
    $password = $_POST['password'];
    if(strlen($password) < 6){
        $errors['password'] = 'your password should be at least 6 characters long';
    }
    //echo "password=$password"; 
    
    //check if there are errors
    if(count($errors) == 0){
        $query = 'INSERT INTO customer 
        (customer_name,customer_email,customer_mobile,password)
        VALUES
        (?,?,?,?)';
        $hash = password_hash($password,PASSWORD_DEFAULT);
        
        $statement = $connection -> prepare( $query );
        $statement -> bind_param('ssss',$customer_name, $customer_email, $customer_mobile, $hash);
        if($statement -> execute() ){
            
             //redirect to home page
             $_SESSION['name'] = $customer_name;
             $_SESSION['email'] = $customer_email;
             header('location: index.php');
             
             //success
             //redirect to booking page
        }
        else{    
            if( $connection -> errno == '1062'){
                $errors['customer_email'] = 'email already used';
            }
            else{
            $errors['registration'] = 'Oops something went wrong!';
            }
        }
    }
}
?>
<html>
    <?php include('includes/head.php')?>
    <body>
        <?php include('includes/navigation.php')?>
        <div class="container">
            <form id="register-form" method="post" action="register.php" class="col-lg-4 offset-lg-4 mt-5">
                <h2>Register your account</h2>
                <?php
                if($errors['customer_name']){
                    $message = $errors['customer_name'];
                    $customer_name_class = 'is-invalid';
                }
                $class = ($customer_name_class) ? $customer_name_class : ''; 
                ?>
                <div class="form-group">
                    <label for="InputName">Your full name</label>
                    <input type="text"
                    id="InputName"
                    class="form-control <?php echo $class;?>"
                    name="customer_name"
                    placeholder="Joe Bloggs"
                    required
                    value="<?php echo $customer_name; ?>">
                    <div class="invalid-feedback">
                        <?php echo $message; ?>
                    </div>
                </div>
                <?php
                if($errors['customer_email']){
                    $message = $errors['customer_email'];
                    $customer_email_class = 'is-invalid';
                }
                $class = ($customer_email_class) ? $customer_email_class : ''; 
                ?>
                <div class="form-group">
                    <label for="InputEmail">Email address</label>
                    <input type="email"
                    id="InputEmail"
                    class="form-control <?php echo $class;?>"
                    name="customer_email"
                    placeholder="example@taxi.com"
                    aria-describedby="emailHelp"
                    required
                    value="<?php echo $customer_email; ?>">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    <div class="invalid-feedback">
                        <?php echo $message; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputMobile">Enter your mobile number</label>
                    <input type="text"
                    id="InputMobile"
                    class="form-control"
                    name="customer_mobile"
                    placeholder="XX00000000"
                    required
                    value="<?php echo $customer_mobile; ?>">
                </div>
                <?php
                if($errors['password']){
                    $message = $errors['password'];
                    $password_class = 'is-invalid';
                }
                $class = ($password_class) ? $password_class : ''; 
                ?>
                <div class="form-group">
                    <label for="InputPassword">Create a password</label>
                    <input type="password"
                    id="InputPassword"
                    class="form-control <?php echo $class;?>"
                    name="password"
                    aria-describedby="passwordHelp"
                    required>
                    <small id="passwordHelp" class="form-text text-muted">Make a strong password. You can reset it later if you forget.</small>
                    <div class="invalid-feedback">
                        <?php echo $message; ?>
                    </div>
                </div>
                <div class="buttons-row">
                    <button type="reest" class="btn btn-light">Clear Form</button>
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </form>
        </div>
    </body>
</html>