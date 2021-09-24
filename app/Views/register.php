<div class="container">
  <div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3>Register</h3>
        <hr>
        <form class="" action="/register" method="post">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>">
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>">
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo set_value('firstname'); ?>">  
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo set_value('lastname'); ?>">  
              </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" value="">
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="">
              </div>
            </div>

            <?php if(isset($validation)): ?>
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?php echo $validation->listErrors(); ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <div class="col-12 col-sm-8 text-right">
              <a href="/">Already have an account</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>