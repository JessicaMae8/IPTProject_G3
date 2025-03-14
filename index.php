<?php
  include('database/database.php');
  include('partials/header.php');
  include('partials/sidebar.php');

  $sql = "SELECT * FROM milktea";

  if (!empty($_GET['search'])) {
      $search = $_GET['search'];
      $sql = "SELECT * FROM milktea WHERE Flavors LIKE '%$search%' OR Sinkers LIKE '%$search%' OR Sizes LIKE '%$search%' OR Price LIKE '%$search%'";
  }
  
  $milktea = $conn->query($sql);  
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

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h5 class="card-title">Milktea List</h5>
              <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addFlavorsModal">Add Milktea Flavor</button>
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


                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['ID']; ?>">Delete</button>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row['ID']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <h1 class="text-danger" style="font-size: 50px"><strong>!</strong></h1>
                                <h5>Are you sure you want to delete this milktea flavor?</h5>
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
                    <td colspan="6" class="text-center">No milktea found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->

                        <!-- Create (Add Flavors) Modal -->
                        <div class="modal fade" id="addFlavorsModal" tabindex="-1" aria-labelledby="addFlavorsLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="database/create.php" method="POST">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Add Milktea Flavors</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                              <div class="mb-3">
                                  <label class="form-label">Flavors</label>
                                  <input type="text" name="Flavors" id="Flavors" class="form-control" placeholder="Enter Flavors" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Sinkers</label>
                                <input type="text" name="Sinkers" id="Sinkers" class="form-control" placeholder="Enter Sinkers"required>
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

                  <div class="mx-4">
                    <nav aria-label="page navigation example">
                      <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                      </ul>
                   </nav>
                </div>
            </div>
                </div>
                </div>
                
                





<?php include('partials/footer.php'); ?>
