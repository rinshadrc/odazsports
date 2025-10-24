<?php
include("includes/config.php");
include("template.php");
head("Odaz Sports | User Role");
main_nav();

?>
<!-- Vendors CSS -->
<link rel="stylesheet" href="<?php echo ROOT ?>plugins/datatables-bs5/datatables.bootstrap5.css">
<link rel="stylesheet" href="<?php echo ROOT ?>plugins/datatables-responsive-bs5/responsive.bootstrap5.css">
<link rel="stylesheet" href="<?php echo ROOT ?>plugins/datatables-buttons-bs5/buttons.bootstrap5.css">
<link rel="stylesheet" href="<?php echo ROOT ?>plugins/datatables-checkboxes-jquery/datatables.checkboxes.css">

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">User Type</h5>
            </div>
            <div class="card-datatable table-responsive">
                <?php
                $usrobj = new MysqliDb(HOST, USER, PWD, DB);
                $usrobj->groupBy("ut.ut_id");
                $usrobj->orderBy("ut.ut_id","ASC");
                $usrobj->join("mv_user mu", "mu.u_type=ut.ut_id", "LEFT");
                $usertparr = $usrobj->get("mv_utype ut", null, "ut.ut_id,ut.ut_name,mu.u_id");
                //echo $usrobj->getLastQuery();
                ?>
                <table class="datatables-usertype table">
                    <thead>
                        <tr>
                            <th>si no</th>
                            <th>User Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usertparr as $key => $utyp) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $utyp["ut_name"] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item openOfcanvas" href="#" data-toggle="offcanvas"  data-id="<?php echo $utyp["ut_id"] ?>" data-name="<?php echo $utyp["ut_name"] ?>"><i class="ri-pencil-line me-1"></i> Edit</a>
                                            <a class="dropdown-item openDelModal" href="#" data-title="User type" data-type="usertype" data-delid="<?php echo $utyp["ut_id"] ?>"><i class="ri-delete-bin-7-line me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                           
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Offcanvas to add new user -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUserType" aria-labelledby="offcanvasAddUserLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User Type</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                    <form class="add-new-user pt-0" id="frmUsers">
                        <input type="hidden" name="action" value="userType">
                        <input type="hidden" name="utId" id="utId">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="User Type" aria-label="John Doe" />
                            <label for="add-user-fullname">User Type</label>
                        </div>
                        <button type="button" class="btn btn-primary me-sm-3 me-1 data-submit" id="btnUpdate">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                    <div id="usertypMsg" class="mt-5"></div>
                </div>
            </div>
        </div>

    </div>
    <!-- / Content -->
<?php footer();
scripts();
?>
    <script src="<?php echo ROOT ?>plugins/datatables-bs5/datatables-bootstrap5.js"></script>
    <script>
    $(function() {
        $(".datatables-usertype").DataTable({
            dom: '<"row"<"col-md-2 d-flex align-items-center justify-content-md-start justify-content-center"><"col-md-10"<"d-flex align-items-center justify-content-md-end justify-content-center"<"me-4"f><"add-new">>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search UserType",
                paginate: {
                    next: '<i class="ri-arrow-right-s-line"></i>',
                    previous: '<i class="ri-arrow-left-s-line"></i>'
                }
            },
        });
        $(".add-new").html("<button class='btn btn-red waves-effect waves-light' data-bs-toggle='offcanvas' data-bs-target='#offcanvasUserType'><i class='ri-add-line me-0 me-sm-1 d-inline-block d-sm-none'></i><span class= 'd-none d-sm-inline-block'>Create UserType </span ></button>")
        $(document).on("click", "#btnUpdate", function(evt) {
            valid = true;
            $("#usertypMsg").html("");
            $("#frmUsers .is-invalid").removeClass("is-invalid");
            if (!$("#txtUser").val()) {
                $("#txtUser").addClass("is-invalid")
                valid = false;
            }
            if (valid) {
                $.ajax({
                    "url": "ajax/user-ajax.php",
                    type: 'post',
                    data: $("#frmUsers").serialize(),
                    success: function(returnData) {
                        try {
                            console.log(returnData);
                            resparray = $.parseJSON(returnData)
                            if (resparray.status == "done") {
                                alert = `<div class="alert alert-success" role="alert">User Details added Successfully</div>`;
                            $("#usertypMsg").html(alert);
                                location.reload();
                            }
                        } catch (err) {}
                    }
                });
            } else {
                alert = `<div class='alert alert-danger alert-dismissible' role='alert'>Please check all inputs<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
            $("#usertypMsg").html(alert);
            }
        });
        
        $(document).on("click",".openOfcanvas",function(cnv){
            cnv.preventDefault();
            $("#utId").val($(this).data('id'));
            $("#txtUser").val($(this).data('name'));
            $(".offcanvas-title").html($(this).data('id') ? "Update User Type" : "Create User Type");
            $('#offcanvasUserType').offcanvas("show"); 
        });
       
    });
</script>
</body>
</html>

    
