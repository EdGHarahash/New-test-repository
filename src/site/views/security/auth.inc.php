<h1>Sign in</h1>
<div>
  <?php
  if(!empty($data['notices'])){
    echo '<ul class="form-errors">';
    foreach($data['notices'] as $notice){
      echo '<li>'.$notice.'</li>';
    }
    echo '</ul>';
  }
  ?>
  <form action="" method="POST">
    <div class="form-group">
      <label for="reg-email">Email</label>
      <input type="email" class="form-control"
             id="reg-email" name="email" placeholder="Email"
             <?php echo (empty($_POST['email']) ? '' : ' value="' . $_POST['email'] . '"'); ?>>
    </div>
    <div class="form-group">
      <label for="reg-password">Password</label>
      <input type="password" class="form-control"
             id="reg-password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-default">Authorize</button>
  </form>
</div>