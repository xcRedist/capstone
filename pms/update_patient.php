<?php
include './config/connection.php';
include './common_service/common_functions.php';

$message = '';
if (isset($_POST['save_Patient'])) {
  
    $hiddenId = $_POST['hidden_id'];

    $patientName = trim($_POST['patient_name']);
    $species = trim($_POST['species']);
    $breed = trim($_POST['breed']);
    $color = trim($_POST['color']);
    $age = trim($_POST['age']);
    $gender = $_POST['gender'];
if ($patientName != '' && $species != '' && 
  $breed != '' && $color != '' && $age != '' && $gender != '') {
      $query = "update `patient` 
    set `patient_name` = '$patientName', 
    `species` = '$species', 
    `breed` = '$breed', 
    `color` = '$color', 
    `age` = '$age', 
    `gender` = '$gender' 
where `id` = $hiddenId;";
try {

  $con->beginTransaction();

  $stmtPatient = $con->prepare($query);
  $stmtPatient->execute();

  $con->commit();

  $message = 'Patient updated successfully.';

} catch(PDOException $ex) {
  $con->rollback();

  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
}
  header("Location:congratulation.php?goto_page=patients.php&message=$message");
  exit;
}



try {
$id = $_GET['id'];
$query = "SELECT `id`, `patient_name`, `species`, 
`breed`, `color`,  `age`, `gender` 
FROM `patient` where `id` = $id;";

  $stmtPatient1 = $con->prepare($query);
  $stmtPatient1->execute();
  $row = $stmtPatient1->fetch(PDO::FETCH_ASSOC);

  $gender = $row['gender'];
} catch(PDOException $ex) {

  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 <?php include './config/data_tables_css.php';?>

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <title>Update Pateint Details</title>

</head>
<body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 <?php include './config/header.php';
include './config/sidebar.php';?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patients</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Update Patients</h3>
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
          <form method="post">
            <input type="hidden" name="hidden_id" 
            value="<?php echo $row['id'];?>">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Patient Name</label>
              <input type="text" id="patient_name" name="patient_name" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['patient_name'];?>" />
              </div>
              <br>
              <br>
              <br>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Species</label> 
                <input type="text" id="species" name="species" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['species'];?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Breed</label>
                <input type="text" id="breed" name="breed" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['breed'];?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Color</label>
                <input type="text" id="color" name="color" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['breed'];?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Age</label>
                <input type="text" id="age" name="age" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['age'];?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Gender</label>
                <!-- $gender -->

                <select class="form-control form-control-sm rounded-0" id="gender" 
                name="gender">
                 <?php echo getGender($gender);?>
                </select>
                
              </div>
              </div>
              
              <div class="clearfix">&nbsp;</div>
              <div class="row">
                <div class="col-lg-11 col-md-10 col-sm-10">&nbsp;</div>
              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                <button type="submit" id="save_Patient" 
                name="save_Patient" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      
    </section>
     <br/>
     <br/>
     <br/>

 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php 
 include './config/footer.php';

  $message = '';
  if(isset($_GET['message'])) {
    $message = $_GET['message'];
  }
?>  
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include './config/site_js_links.php'; ?>
<?php include './config/data_tables_js.php'; ?>


<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
  showMenuSelected("#mnu_patients", "#mi_patients");

  var message = '<?php echo $message;?>';

  if(message !== '') {
    showCustomMessage(message);
  }
  $('#date_of_birth').datetimepicker({
        format: 'L'
    });
      
    
   $(function () {
    $("#all_patients").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#all_patients_wrapper .col-md-6:eq(0)');
    
  });

</script>
</body>
</html>