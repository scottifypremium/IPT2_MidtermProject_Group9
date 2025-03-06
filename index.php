<?php
  include('partials\header.php');
  include('partials\sidebar.php');
  include('database/database.php');

  // Your PHP BACK CODE HERE

?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Mobile Legends System</h1>
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
                <div>
                  <h5 class="card-title">Players</h5>
                </div>
                <div>
                  <button class="btn btn-primary btn-sm mt-4 mx-3">Add Players</button>
                </div>
              </div>

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ML ID</th>
                    <th scope="col">Team Name</th>
                    <th scope="col">IGN</th>
                    <th scope="col">Player Name</th>
                    <th scope="col">Position</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">19213213</th>
                    <td>Ghost_Riders</td>
                    <td>ToniF</td>
                    <td>Sabrina Carpenter</td>
                    <td>Gold Laner</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">18473212</th>
                    <td>Ghost_Riders</td>
                    <td>PumpedUpKicks</td>
                    <td>Enrique Iglesias</td>
                    <td>Mid Laner</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">37092315</th>
                    <td>Ghost_Riders</td>
                    <td>gODISaWoman</td>
                    <td>Ariana Grande</td>
                    <td>EXP Laner</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">17092345</th>
                    <td>Ghost_Riders</td>
                    <td>gET_hUB</td>
                    <td>Billie Eilish</td>
                    <td>Roamer</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">12445310</th>
                    <td>Ghost_Riders</td>
                    <td>GG_Guatno</td>
                    <td>James Phillip Guatno</td>
                    <td>Jungler</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">10213045</th>
                    <td>Banditz_Outlaws</td>
                    <td>Zhuxin_Flowers</td>
                    <td>Jerelyn Penos</td>
                    <td>EXP Laner</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">27024513</th>
                    <td>Banditz_Outlaws</td>
                    <td>scottifyz</td>
                    <td>Scott Denver</td>
                    <td>Gold Laner</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">10054210</th>
                    <td>Banditz_Outlaws</td>
                    <td>ReadyPlayerOne</td>
                    <td>John Paul Guiuan</td>
                    <td>Mid Laner</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">16502145</th>
                    <td>Banditz_Outlaws</td>
                    <td>DoogieStyle</td>
                    <td>Jessa Azarcon</td>
                    <td>Jungler</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">51024512</th>
                    <td>Banditz_Outlaws</td>
                    <td>dj_peeps</td>
                    <td>Raver Jinx</td>
                    <td>Roamer</td>
                    <td class="d-flex justify-content-center">
                      <button class="btn btn-success btn-sm mx-1">Edit</button>
                      <button class="btn btn-primary btn-sm mx-1" title="View Employee Information" data-bs-toggle="modal" data-bs-target="#editInfo">View</button>
                      <button class="btn btn-danger btn-sm mx-1">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- End Default Table Example -->
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
          </div>

        </div>

        
      </div>

      <!-- Modal -->
      <div class="modal fade" id="editInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editInfoLabel">Employee Information</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php
include('partials\footer.php');
?>