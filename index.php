<?php
  include('database/database.php');
  include('partials/header.php');
  include('partials/sidebar.php');

  // Pagination variables
  $limit = 5; // Number of records per page
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
  $offset = ($page - 1) * $limit; // Offset for SQL query

  // Search functionality
  $search = "";
  if (isset($_GET['search'])) {
      $search = $_GET['search'];
  }

  // Build SQL query with pagination and search functionality
  if (!empty($search)) {
      $sql = "SELECT * FROM milktea 
              WHERE Flavors LIKE '%$search%' 
              OR Sinkers LIKE '%$search%' 
              OR Sizes LIKE '%$search%' 
              OR Price LIKE '%$search%'
              LIMIT $offset, $limit";
  } else {
      $sql = "SELECT * FROM milktea LIMIT $offset, $limit";
  }

  // Debugging: Print the SQL query
  echo $sql; // This will help you see the actual query being executed

  // Execute the query
  $result = $conn->query($sql);

  // Check for errors in the query execution
  if (!$result) {
      die("Query failed: " . $conn->error);
  }

  // Get total records for pagination (with or without search)
  $total_sql = "SELECT COUNT(*) as total FROM milktea";
  if (!empty($search)) {
      $total_sql = "SELECT COUNT(*) as total FROM milktea 
                    WHERE Flavors LIKE '%$search%' 
                    OR Sinkers LIKE '%$search%' 
                    OR Sizes LIKE '%$search%' 
                    OR Price LIKE '%$search%'";
  }

  // Get the total number of records
  $total_result = $conn->query($total_sql);
  $total_row = $total_result->fetch_assoc();
  $total_records = $total_row['total'];
  $total_pages = ceil($total_records / $limit);

  // Get data for milktea
  $milktea = $conn->query($sql);  

  // Handle session status (if any)
  $status = '';
  if (isset($_SESSION['status'])) {
      $status = $_SESSION['status'];
      unset($_SESSION['status']);
  }
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Milktea Information Management System</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <head>
    <title>Milktea I.M.S</title>
    <style>
        .btn-primary {
            background-color:rgb(43, 130, 211) !important;
            border-color:rgb(0, 0, 0) !important;
        }
        .btn-success {
            background-color:rgb(40, 202, 83) !important;
            border-color:rgb(0, 0, 0) !important;
        }
        .btn-danger {
            background-color: rgb(223, 82, 71) !important;
            border-color: rgb(0, 0, 0) !important;
        }

        .page-item.active .page-link {
            background-color: #F0EAD2 !important;
            border-color: #ffcc00 !important;
            color: black !important;
        }

        .page-link {
            background-color: #7F5539 !important;
            border-color:rgb(10, 8, 0) !important;
            color: #D7BE82 !important;
        }
    </style>
</head>


  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">Milktea List</h5>
              <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addFlavorsModal">Add Milktea Order</button>
            </div>

            <!-- Default Table -->
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Flavors</th>
                  <th>Sinkers</th>
                  <th>Sizes</th>
                  <th>Price</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($milktea->num_rows > 0): ?>
                  <?php while ($row = $milktea->fetch_assoc()): ?>
                    <tr>
                    <th scope="row"><?php echo $row['ID']; ?></th>
                      <td><?php echo $row['Flavors']; ?></td>
                      <td><?php echo $row['Sinkers']; ?></td>
                      <td><?php echo $row['Sizes']; ?></td>
                      <td><?php echo $row['Price']; ?></td>
                      <td class="d-flex justify-content-center">

                            <!-- View Button -->
                            <button class="btn btn-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#ViewModal<?php echo $row['ID']; ?>">View</button>

                            <!-- View Modal -->
                            <div class="modal fade" id="ViewModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="ViewModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">View Milktea Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label">Flavors</label>
                                    <input type="text" class="form-control" value="<?php echo $row['Flavors']; ?>" disabled>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Sinkers</label>
                                    <input type="text" class="form-control" value="<?php echo $row['Sinkers']; ?>" disabled>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Sizes</label>
                                    <input type="text" class="form-control" value="<?php echo $row['Sizes']; ?>" disabled>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="int" class="form-control" value="<?php echo $row['Price']; ?>" disabled>
                                  </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                      
                        <!-- Edit Button -->
                        <button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['ID']; ?>">Edit</button>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Edit Milktea List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="database/update.php" method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                  <div class="mb-3">
                                    <label class="form-label">Flavors</label>
                                    <input type="text" name="Flavors" class="form-control" value="<?php echo $row['Flavors']; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Sinkers</label>
                                    <input type="text" name="Sinkers" class="form-control" value="<?php echo $row['Sinkers']; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Sizes</label>
                                    <input type="text" name="Sizes" class="form-control" value="<?php echo $row['Sizes']; ?>" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="int" name="Price" class="form-control" value="<?php echo $row['Price']; ?>" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>


                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['ID']; ?>">Delete</button>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row['ID']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <h1 class="text-danger" style="font-size: 50px"><strong>!</strong></h1>
                                <h5>Are you sure you want to delete this?</h5>
                                <h6>This action cannot be undone.</h6>
                              </div>
                              <div class="modal-footer d-flex justify-content-center">
                                <form action="database/delete.php" method="POST">
                                  <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">No Milktea List Found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>

<!-- Pagination Links -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a>
        </li>
    </ul>
</nav>

</main><!-- End #main -->

                        <!-- Create (Add Flavors) Modal -->
                        <div class="modal fade" id="addFlavorsModal" tabindex="-1" aria-labelledby="addFlavorsLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="database/create.php" method="POST">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Add Milktea Order</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                              <div class="mb-3">
                                  <label class="form-label">Flavors</label>
                                  <select class="form-control" id="Flavors" name="Flavors" required>
                                    <option value="" disabled selected>What's your Flavor?</option>
                                    <option value="Avocado">Avocado</option>
                                    <option value="Banana">Banana</option>
                                    <option value="Black Forest">Black Forest</option>
                                    <option value="Blueberry">Blueberry</option>
                                    <option value="Brown Sugar">Brown Sugar</option>
                                    <option value="Buko Pandan">Buko Pandan</option>
                                    <option value="Caramel">Caramel</option>
                                    <option value="Cheesecake">Cheesecake</option>
                                    <option value="Choco Fudge">Choco Fudge</option>
                                    <option value="Choco Mint">Choco Mint</option>
                                    <option value="Cookies and Cream">Cookies and Cream</option>
                                    <option value="Dark Choco">Dark Choco</option>
                                    <option value="Hokkaido">Hokkaido</option>
                                    <option value="Mango">Mango</option>
                                    <option value="Matcha">Matcha</option>
                                    <option value="Melon">Melon</option>
                                    <option value="Mocha">Mocha</option>
                                    <option value="Okinawa">Okinawa</option>
                                    <option value="Oreo">Oreo</option>
                                    <option value="Oreo Cheesecake">Oreo Cheesecake</option>
                                    <option value="Peach">Peach</option>
                                    <option value="Red Velvet">Red Velvet</option>
                                    <option value="Rocky Road">Rocky Road</option>
                                    <option value="Salted Caramel">Salted Caramel</option>
                                    <option value="Strawberry">Strawberry</option>
                                    <option value="Taro">Taro</option>
                                    <option value="Thai">Thai</option>
                                    <option value="Ube">Ube</option>
                                    <option value="Vanilla">Vanilla</option>
                                    <option value="Wintermelon">Wintermelon</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Sinkers</label>
                                <select class="form-control" id="Sinkers" name="Sinkers" required>
                                  <option value="" disabled selected>Choose Sinkers</option>
                                  <option value="Boba Pearl">Boba Pearl</option>
                                  <option value="Chia Seeds">Chia Seeds</option>
                                  <option value="Coconut Jelly">Coconut Jelly</option>
                                  <option value="Coffee Jelly">Coffee Jelly</option>
                                  <option value="Crystal Boba">Crystal Boba</option>
                                  <option value="Fruit Jelly">Fruit Jelly</option>
                                  <option value="Grass Jelly">Grass Jelly</option>
                                  <option value="Honey Boba">Honey Boba</option>
                                  <option value="Lychee Jelly">Lychee Jelly</option>
                                  <option value="Mango Jelly">Mango Jelly</option>
                                  <option value="Nata De Coco">Nata De Coco</optio>
                                  <option value="Popping Boba">Popping Boba</option>
                                  <option value="Pudding">Pudding</option>
                                  <option value="Red Bean">Red Bean</option>
                                  <option value="Sago">Sago</option>
                                  <option value="Strawberry Jelly">Strawberry Jelly</option>
                                  <option value="Tapioca Pearl">Tapioca Pearl</option>
                                  <option value="Taro Balls">Taro Balls</option>
                                  <option value="White Pearl">White Pearl</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Sizes</label>
                                <input type="text" name="Sizes" id="Sizes" class="form-control" placeholder="Enter Sizes"required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="int" name="Price" id="Price" class="form-control" placeholder="Enter Price"required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Add Flavors</button>
                            </div>
                          </div>
                      </form>
                    </div>
                  </div>

                
                





<?php include('partials/footer.php'); ?>
