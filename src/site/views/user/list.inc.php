<h1>Users List</h1>
<div class="user-list row">

  <?php
  foreach ($data['profiles'] as $id=>$profile) {
    $avatar = empty($profile['avatar']) ? '/img/def-avatar.jpg' : $profile['avatar'];
    ?>
    <div class="profile-thumbnail">
      <a href="/user/show/<?php echo $profile['id']; ?>" class="profile-link">
        <img src="<?php echo $avatar; ?>" alt="Name Surname" class="profile-avatar">
        <h3 class="profile-name"><?php echo $profile['name']; ?></h3>
      </a>
    </div>
    <?php
  }
  ?>

</div>