<?php include 'server.php' ; ?>
<?php include 'connect.php' ; ?>
<?php include 'index.php' ; ?>

<HTML>

    <head>
        <TITLE>Front Page</TITLE>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="bootstrap.min.css">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body data-spy="scroll" data-target=".navbar" data-offset="50">

        <nav class="navbar navbar-vertical navbar-expand-sm navbar-dark fixed-top">
               
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavdropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse content-end" id="navbarNavdropdown">
                    <ul class="navbar-nav">
                    <li class="nav-item" ><a class="nav-link js-scroll-trigger" href="#home">HOME</a></li>
                    <li class="nav-item" ><a class="nav-link js-scroll-trigger" href="#log-in">LOGIN</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#signup">SIGNUP</a></li>
                    </ul>
                </div>
                

            </ul>
        
        </nav>

        <div id="home" class="container-cover h-100 w-100 one">
            <div class="container two">
                <center>
                    <h1 style="font-family: 'Baloo Chettan 2', cursive; color: #f5f5f5"> HERE WeGo!
                    </h1>
                </center>
                <br> 
                This is a Simple Routing Application that displays the Route between the entered Source and Destination.
                Login / Signup to explore more.
            </div>
        </div>


        <div id="log-in" class="container-cover w-100 h-100 one">
            <div class="container two">
            <form class="col-10 offest-1 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3" action="connect.php" method="post">

                <?php include('errors.php') ?>
        
                    <div class="form-group" id="sign-up">
                        <p>LOGIN</p>
                    </div>
                    <div class="container rounded-bottom">
        
                        
                       
        
                        <div class="form-group">
                                       
                            <input type="text" class="form-control rounded-pill  border border-success" placeholder="Username" name="username" required>
                            
                        </div>   
        
                        <div class="form-group">
        
                       
                        <input type="password" placeholder="EnterYourPassword" class="form-control rounded-pill  border border-success" id="exampleInputPassword1" name="password" required>
                        
                        </div>
        
                        <div>
                           
                            <br>
                        </div>
        
                        <center>
        
                        <button type="submit" name="log-in" class="btn-outline-light btn-toggle btn-large btn-block rounded-pill"><strong>Sign In</strong></button>
        
                        </center>
        
                        <center>
                        
                        <div class="space">
                            <font color="white">
                            Don't have an account?</font>
                            <Br>
                        </div>
        
                        <div class="log">
                            <a href="#signup" class="text-light nav-link js-scroll-trigger">
                                <b>SIGN UP NOW</b>
                            </a>
                        </div>
        
                        </center>
        
                    </div>
                  </form>
        </div>
    
        </div>

        <div id="signup" class="container-cover w-100 h-100 one">
            <div class="container two">
            <form class="col-10 offset-1 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3" action="server.php" method="post">
            
                <?php include('errors.php') ?>
        
                    <div class="form-group" id="sign-up">
                        <p>Create Account</p>
                    </div>
                    <div class="container">
        
                        
                        <div class="form-group">
                                       
                            <input type="text" class="form-control rounded-pill  border border-success" placeholder="Username" name="username" required>
                            
                        </div>    
                       
        
                        <div class="form-group">
        
                                       
                        <input type="email" class="form-control rounded-pill  border border-success" placeholder="eg. yourname@gmail.com" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                        
                        </div>
        
                        <div class="form-group">
                       
                        <input type="password" placeholder="Enter Password" class="form-control rounded-pill  border border-success" id="exampleInputPassword1" name="password1" required>
                        
                        </div>
        
                        <div class="form-group">
                       
                            <input type="password" placeholder="Confirm Password" class="form-control rounded-pill  border border-success" id="exampleInputPassword1" name="password2" required>
                            
                        </div>
        
                        <div>       
                    <br>
                        </div>
        
                        <center>
        
                        <button type="submit" name="sign-up" class="btn-outline-light btn-toggle btn-block rounded-pill">Sign Up</button>
        
                        </center>
                        <div class="container" id="bottom">
        
                            <center>
                        
                                <div class="space" style="color: white">
                                    Already have an account?
                                    <Br>
                                </div>
                
                                <div class="log">
                                    <a href="#log-in" class="text-light nav-link js-scroll-trigger">
                                        LOGIN HERE
                                    </a>
                                </div>
                
                                </center>
        
        
                    </div>
                    
                  </form>

            </div>

            
        </div>
    <script src="jquery.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>    
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/resume.min.js"></script>

</body>
</HTML>
