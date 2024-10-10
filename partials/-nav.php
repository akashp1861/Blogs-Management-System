<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      <!--  show admin_dashboard OR user_dashboard  -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
          <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/LoginSystem/-admin-dashboard.php">Home</a>
        </li>
          <?php else: ?>


           <li class="nav-item">
             <a class="nav-link active" aria-current="page" href="/LoginSystem/-user-dashboard.php">Home</a>
           </li>
          <?php endif; ?>
     
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/LoginSystem/BlogPost/-blog-post-feed.php">Blogs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/LoginSystem/BlogPost/-create-post.php">Create Blog</a>
        </li>   



        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
        <li class="nav-item">
          <a class="nav-link" href="/LoginSystem/BlogPost/-view-blog.php">Your Blogs</a>
        </li>
        <?php else: ?>
          <li class="nav-item">
          <a class="nav-link" href="/LoginSystem/BlogPost/-view-blog-by-user.php">Your Blogs</a>
        </li>
        <?php endif; ?>

        <!-- Only show Manage Users if the logged-in user is an admin -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
        <li class="nav-item">
          <a class="nav-link" href="/LoginSystem/BlogPost/-view-users.php">Manage Users</a>
        </li>
        <?php endif; ?>
      </ul>       
      
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="/LoginSystem/-update.php">Profile</a></li>
            <li><a class="dropdown-item" href="/LoginSystem/-signup.php">Signup</a></li>
            <li><a class="dropdown-item" href="" onclick="confirmLogout(event)">Logout</a></li>
          </ul>
        </li>
      </ul>
      
    </div>
  </div>
</nav>

<!-- Add the JavaScript for logout confirmation -->
<script>
  function confirmLogout(event) {
    event.preventDefault(); // Prevent the default link behavior
    let result = confirm("Are you sure you want to log out?");
    if (result) {
      // If the user confirms, redirect to logout.php
      window.location.href = '/LoginSystem/-logout.php';
    }
  }
</script>
