<?php
session_start();
 include('partials\header.php');
 include('partials\sidebar.php');
$conn = mysqli_connect("localhost", "root", "", "esports_db");

// Default query to fetch all players
$sql = "SELECT * FROM players ORDER BY id DESC";

// If a search query is submitted
if (isset($_POST['search'])) {
    $search = $_POST['search'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM players WHERE id LIKE ? OR ml_id LIKE ? OR team_name LIKE ? OR player_name LIKE ? OR ign LIKE ?";

    $stmt = $conn->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all players if no search query
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CICTEsports: MLBB Players List</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="assets/css/style1.css">
    <link rel="stylesheet" href="assets/css/style_modal.css">
<main id="main" class="main">

<div class="pagetitle">
  <h1 class="profile-title">Mobile Legends: Bang Bang Players List</h1>
</div><!-- End Page Title -->

<div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title">Players</h5>
                </div>
                <div>
                <button class="btn btn-primary my-3" id="addPlayerBtn"><i class="ri-user-add-line"></i>Add Player</button>
                </div>
              </div>
</head>
<body>
    <div class="container mt-4 table-responsive">
        
        <table class="table-hover table table-bordered" id="playersTable">
             <thead class="thead-dark">
                            <tr>
                                <th>ML ID</th>
                                <th>Team Name</th>
                                <th>IGN</th>
                                <th>Player Name</th>
                                <th>Position</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['ml_id']}</td>
                                        <td>{$row['team_name']}</td>
                                        <td>{$row['ign']}</td>
                                        <td>{$row['player_name']}</td>
                                        <td>{$row['position']}</td>
                                        <td>
                                            <button class='btn btn-success edit-btn' data-id='{$row['id']}' data-mlid='{$row['ml_id']}' data-team='{$row['team_name']}' data-ign='{$row['ign']}' data-player='{$row['player_name']}' data-position='{$row['position']}'>Edit</button>
                                            
                                            <button class='btn btn-info view-btn' data-id='{$row['id']}' data-mlid='{$row['ml_id']}' data-team='{$row['team_name']}' data-ign='{$row['ign']}' data-player='{$row['player_name']}' data-position='{$row['position']}'>View</button>
                                            
                                            <button class='btn btn-danger delete-btn' data-id='{$row['id']}'>Delete</button>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No results found</td></tr>";
                            }
                            ?>
                        </tbody>
        </table>
    </div>

 <!-- Add Player Modal -->
<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle"><i class="ri-user-add-line"></i> Add Player</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="playerForm">
                    <input type="hidden" id="playerId">
                    <div class="mb-3">
                        <label class="form-label"><strong>ML ID</strong></label>
                        <input type="text" class="form-control" id="ml_id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Team Name</strong></label>
                        <input type="text" class="form-control" id="team_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>IGN</strong></label>
                        <input type="text" class="form-control" id="ign" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Player Name</strong></label>
                        <input type="text" class="form-control" id="player_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Position</strong></label>
                        <input type="text" class="form-control" id="position" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Player Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Player</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label"><strong>ML ID</strong></label>
                        <input type="text" class="form-control" id="edit_ml_id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Team Name</strong></label>
                        <input type="text" class="form-control" id="edit_team_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>IGN</strong></label>
                        <input type="text" class="form-control" id="edit_ign" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Player Name</strong></label>
                        <input type="text" class="form-control" id="edit_player_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Position</strong></label>
                        <input type="text" class="form-control" id="edit_position" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Player Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewModalLabel">Player Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="player-details">
                    <div class="detail-item">
                        <span class="detail-label"><strong>ML ID:</strong></span>
                        <span class="detail-value" id="view_ml_id"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><strong>Team Name:</strong></span>
                        <span class="detail-value" id="view_team_name"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><strong>IGN:</strong></span>
                        <span class="detail-value" id="view_ign"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><strong>Player Name:</strong></span>
                        <span class="detail-value" id="view_player_name"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><strong>Position:</strong></span>
                        <span class="detail-value" id="view_position"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Delete Player</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this player?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="mx-4">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
              </nav>
            </div>

        </main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Open Add Player Modal
    $("#addPlayerBtn").click(function() {
        $("#playerId").val('');
        $("#playerForm")[0].reset();
        $("#playerModal").modal("show");
    });

    // Save Player (Add or Edit)
    $("#playerForm").submit(function(e) {
        e.preventDefault();
        let id = $("#playerId").val();
        let data = {
            id: id,
            ml_id: $("#ml_id").val(),
            team_name: $("#team_name").val(),
            ign: $("#ign").val(),
            player_name: $("#player_name").val(),
            position: $("#position").val()
        };

        $.post(id ? "update_player.php" : "add_player.php", data, function(response) {
            if (response.trim() === "success") {
                location.reload(); // Reload page after success
            } else {
                alert("Failed to save player. Error: " + response);
            }
        });
    });

    // Handle Edit Button Click
    $(document).on("click", ".edit-btn", function() {
        let id = $(this).data("id");
        let mlid = $(this).data("mlid");
        let team = $(this).data("team");
        let ign = $(this).data("ign");
        let player = $(this).data("player");
        let position = $(this).data("position");

        // Populate the edit modal with data
        $("#edit_id").val(id);
        $("#edit_ml_id").val(mlid);
        $("#edit_team_name").val(team);
        $("#edit_ign").val(ign);
        $("#edit_player_name").val(player);
        $("#edit_position").val(position);

        // Show the edit modal
        $("#editModal").modal("show");
    });

    // Handle View Button Click
    $(document).on("click", ".view-btn", function() {
        let mlid = $(this).data("mlid");
        let team = $(this).data("team");
        let ign = $(this).data("ign");
        let player = $(this).data("player");
        let position = $(this).data("position");

        // Populate the view modal with data
        $("#view_ml_id").text(mlid);
        $("#view_team_name").text(team);
        $("#view_ign").text(ign);
        $("#view_player_name").text(player);
        $("#view_position").text(position);

        // Show the view modal
        $("#viewModal").modal("show");
    });

   $(document).ready(function() {
    let playerIdToDelete = null;

    // Handle Delete Button Click
    $(document).on("click", ".delete-btn", function() {
        playerIdToDelete = $(this).data("id"); // Store the player ID to delete
        $("#deleteModal").modal("show"); // Show the delete confirmation modal
    });

    // Handle Confirm Delete Button Click
    $("#confirmDelete").click(function(e) {
            if (playerIdToDelete) {
                $.post("delete_player.php", { id: playerIdToDelete }, function(response) {
                    if (response.trim() === "success") {
                        location.reload(); // Reload page after success
                        alert("Player deleted successfully!");
                    } else {
                        alert("Failed to delete player. Error: " + response);
                    }
                }).fail(function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                    alert("AJAX request failed. Error: " + error);
                });

                // Close the modal
                $("#deleteModal").modal("hide");
                playerIdToDelete = null; // Reset the player ID
            }
        });
    });
    // Handle Edit Form Submission
    $("#editForm").submit(function(e) {
        e.preventDefault(); // Prevent form from refreshing the page

        let data = {
            id: $("#edit_id").val(),
            ml_id: $("#edit_ml_id").val(),
            team_name: $("#edit_team_name").val(),
            ign: $("#edit_ign").val(),
            player_name: $("#edit_player_name").val(),
            position: $("#edit_position").val()
        };

        $.ajax({
            url: "edit_player.php",
            type: "POST",
            data: data,
            success: function(response) {
                if (response.trim() === "success") {
                    location.reload(); // Reload page after success
                    // Update the table row dynamically
                    let row = $(`button[data-id='${data.id}']`).closest("tr");
                    row.find("td:eq(0)").text(data.ml_id); // ML ID
                    row.find("td:eq(1)").text(data.team_name); // Team Name
                    row.find("td:eq(2)").text(data.ign); // IGN
                    row.find("td:eq(3)").text(data.player_name); // Player Name
                    row.find("td:eq(4)").text(data.position); // Position

                    // Close the modal
                    $("#editModal").modal("hide");
                    alert("Player updated successfully!");
                } else {
                    alert("Failed to update player. Error: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", error);
                alert("AJAX request failed. Error: " + error);
            }
        });
    });
});

    // Handle Search Form Submission
    $(".search-form").submit(function(e) {
        e.preventDefault(); // Prevent form submission
        let searchQuery = $("input[name='search']").val();

        // Send AJAX request to fetch filtered results
        $.ajax({
            url: "index.php",
            type: "POST",
            data: { search: searchQuery },
            success: function(response) {
                // Update the table body with the filtered results
                $("#playersTable tbody").html($(response).find("#playersTable tbody").html());

                // Reattach event listeners after updating the table
                attachEventListeners();
            }
        });
    })
</script>

<script>
    function selectProfileSuggestion(imageSrc) {
        // Set the selected image as the profile picture
        document.getElementById('profile_image').value = ''; // Clear the file input
        // You can set the selected image to a hidden input or handle it as needed
        console.log('Selected profile suggestion:', imageSrc);
        // Example: Set the selected image to a hidden input field
        document.getElementById('selected_profile_image').value = imageSrc;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/lazysizes@5.3.2/lazysizes.min.js"></script>
    
</body>



</html>
<?php
include('partials\footer.php');
?>