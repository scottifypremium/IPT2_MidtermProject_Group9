<?php
include 'db_connect.php';
?>



<div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="search_players.php">
      <input type="text" name="searh" value="<?php if(isset($_GET['search'])){echo $_GET['search']; }?>" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
</div>

    <div class="col-md-12">
    <div class="card mt-4">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ML ID</th>
            <th>Team Name</th>
            <th>IGN</th>
            <th>Player Name</th>
            <th>Position</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if(isset($_GET['search'])){
          }
          $filervalues = $_GET ['search'];
          $query = "SELECT * FROM players WHERE CONCAT (ml_id, team_name, ign, player_name, position) LIKE '%$filervalues%'"; 
          $query_run = mysqli_query($conn, $query);

          if(mysqli_num_rows($query_run) > 0)
          {
            foreach($query_run as $items)  
            {
              ?>
              <tr>
                <td><?= $items['id'];?></td>
                <td><?= $items['ml_id'];?></td>
                <td><?= $items['team_name'];?></td>
                <td><?= $items['ign'];?></td>
                <td><?= $items['player_name'];?></td>
                <td><?= $items['position'];?></td>
              </tr>
              <?php
            }
          }
          else 
          { 
            ?>
            <tr>
              <td colspan="7">No Record Found</td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  
