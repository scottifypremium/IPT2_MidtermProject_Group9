<?php
 include('partials\header.php');
 include('partials\sidebar.php');
$conn = mysqli_connect("localhost", "root", "", "esports_db");
$result = $conn->query("SELECT * FROM players");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CICTEsports: MLBB Players List</title>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Mobile Legends: Bang Bang Players List</h1>
</div><!-- End Page Title -->

<div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title">Players</h5>
                </div>
                <div>
                <button class="btn btn-primary mb-3" id="addPlayerBtn">Add Player</button>
                </div>
              </div>

<body>
    <div class="container mt-4">
        
        <table class="table table-bordered">
            <thead>
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
    $result = $conn->query("SELECT * FROM players ORDER BY id DESC");

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
    ?>
</tbody>


</table>

 <!-- Modal for Adding Player -->
<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Player</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="playerForm">
                    <input type="hidden" id="playerId">
                    <div class="mb-3">
                        <label>ML ID</label>
                        <input type="text" class="form-control" id="ml_id" required>
                    </div>
                    <div class="mb-3">
                        <label>Team Name</label>
                        <input type="text" class="form-control" id="team_name" required>
                    </div>
                    <div class="mb-3">
                        <label>IGN</label>
                        <input type="text" class="form-control" id="ign" required>
                    </div>
                    <div class="mb-3">
                        <label>Player Name</label>
                        <input type="text" class="form-control" id="player_name" required>
                    </div>
                    <div class="mb-3">
                        <label>Position</label>
                        <input type="text" class="form-control" id="position" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Player Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Player</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label>ML ID</label>
                        <input type="text" class="form-control" id="edit_ml_id" required>
                    </div>
                    <div class="mb-3">
                        <label>Team Name</label>
                        <input type="text" class="form-control" id="edit_team_name" required>
                    </div>
                    <div class="mb-3">
                        <label>IGN</label>
                        <input type="text" class="form-control" id="edit_ign" required>
                    </div>
                    <div class="mb-3">
                        <label>Player Name</label>
                        <input type="text" class="form-control" id="edit_player_name" required>
                    </div>
                    <div class="mb-3">
                        <label>Position</label>
                        <input type="text" class="form-control" id="edit_position" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Player Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Player Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ML ID:</strong> <span id="view_ml_id"></span></p>
                <p><strong>Team Name:</strong> <span id="view_team_name"></span></p>
                <p><strong>IGN:</strong> <span id="view_ign"></span></p>
                <p><strong>Player Name:</strong> <span id="view_player_name"></span></p>
                <p><strong>Position:</strong> <span id="view_position"></span></p>
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
        $("#playerModal").modal("show"); // Ensure Bootstrap Modal is being triggered
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
            location.reload(); // Reload page after success
        });
    });
});

$(document).ready(function() {

// Handle Edit Button Click
$(".edit-btn").click(function() {
    $("#edit_id").val($(this).data("id"));
    $("#edit_ml_id").val($(this).data("mlid"));
    $("#edit_team_name").val($(this).data("team"));
    $("#edit_ign").val($(this).data("ign"));
    $("#edit_player_name").val($(this).data("player"));
    $("#edit_position").val($(this).data("position"));
    $("#editModal").modal("show");
});

// Handle View Button Click
$(".view-btn").click(function() {
    $("#view_ml_id").text($(this).data("mlid"));
    $("#view_team_name").text($(this).data("team"));
    $("#view_ign").text($(this).data("ign"));
    $("#view_player_name").text($(this).data("player"));
    $("#view_position").text($(this).data("position"));
    $("#viewModal").modal("show");
});

// Handle Delete Button Click
$(".delete-btn").click(function() {
    let playerId = $(this).data("id");
    if (confirm("Are you sure you want to delete this player?")) {
        $.post("delete_player.php", { id: playerId }, function(response) {
            location.reload();
        });
    }
});

// Handle Edit Form Submission
$("#editForm").submit(function(e) {
    e.preventDefault();
    $.post("edit_player.php", {
        id: $("#edit_id").val(),
        ml_id: $("#edit_ml_id").val(),
        team_name: $("#edit_team_name").val(),
        ign: $("#edit_ign").val(),
        player_name: $("#edit_player_name").val(),
        position: $("#edit_position").val()
    }, function(response) {
        location.reload();
    });
});

});
</script>

<script>
$(document).ready(function() {

    // Handle Edit Button Click
    $(".edit-btn").click(function() {
        $("#edit_id").val($(this).data("id"));
        $("#edit_ml_id").val($(this).data("mlid"));
        $("#edit_team_name").val($(this).data("team"));
        $("#edit_ign").val($(this).data("ign"));
        $("#edit_player_name").val($(this).data("player"));
        $("#edit_position").val($(this).data("position"));
        $("#editModal").modal("show");
    });

    // Handle View Button Click
    $(".view-btn").click(function() {
        $("#view_ml_id").text($(this).data("mlid"));
        $("#view_team_name").text($(this).data("team"));
        $("#view_ign").text($(this).data("ign"));
        $("#view_player_name").text($(this).data("player"));
        $("#view_position").text($(this).data("position"));
        $("#viewModal").modal("show");
    });

});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Handle Edit Button Click - Fill Form with Data
    $(".edit-btn").click(function() {
        $("#edit_id").val($(this).data("id"));
        $("#edit_ml_id").val($(this).data("mlid"));
        $("#edit_team_name").val($(this).data("team"));
        $("#edit_ign").val($(this).data("ign"));
        $("#edit_player_name").val($(this).data("player"));
        $("#edit_position").val($(this).data("position"));
        $("#editModal").modal("show");
    });

    // Handle Update Button Click
    $("#editForm").submit(function(e) {
        e.preventDefault(); // Prevent form from refreshing the page

        $.ajax({
            url: "edit_player.php",
            type: "POST",
            data: {
                id: $("#edit_id").val(),
                ml_id: $("#edit_ml_id").val(),
                team_name: $("#edit_team_name").val(),
                ign: $("#edit_ign").val(),
                player_name: $("#edit_player_name").val(),
                position: $("#edit_position").val()
            },
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Player updated successfully!");
                    location.reload();
            }
        });
    });

});

</script>


<script>
        function searchPlayers() {
            let searchQuery = $("#searchInput").val();
            let filterType = $("#filterType").val();

            $.post("search_players.php", {
                searchQuery: searchQuery,
                filterType: filterType
            }, function(data) {
                $("#playersTable").html(data);
            });
        }
    </script>
    
</body>

</html>
<?php
include('partials\footer.php');
?>