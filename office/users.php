<?php
include("template.php");
head("Odaz Sports | List of Users");
main_nav();

?>
<!-- Vendors CSS -->
<link rel="stylesheet" href="<?php echo ROOT ?>plugins/datatables-bs5/datatables.bootstrap5.css">

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Users</h5>
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <?php
                $empobj = new MysqliDb(HOST, USER, PWD, DB);
                $empobj->where('u_status', 9, "<>");
                $empobj->orderBy('u_type', "ASC");
                $empobj->join("mv_utype ut", "ut.ut_id=u_type");
                $emparr = $empobj->get("mv_user mu", null, "mu.u_id,mu.u_name,mu.u_type,mu.u_email,mu.u_phone,mu.u_address,ut.ut_name");
                ?>
                <table class="datatables-users table">
                    <thead>
                        <tr>
                            <th>Si no</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($emparr as $key => $empl) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $empl["u_name"] ?></td>
                                <td><?php echo $empl["ut_name"] ?></td>
                                <td><?php echo $empl["u_email"] ?></td>
                                <td><?php echo $empl["u_phone"] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#pwdModal" data-title="<?php echo $empl["u_name"] ?>" data-id="<?php echo $empl["u_id"] ?>"><i class="ri-lock-line me-1"></i> Change password</a>
                                            <a class="dropdown-item" href="" data-bs-toggle='offcanvas' data-bs-target='#offcanvasAddUser' data-id="<?php echo $empl["u_id"] ?>" data-title="<?php echo $empl["u_name"] ?>" data-phone="<?php echo $empl["u_phone"] ?>"  data-email="<?php echo $empl["u_email"] ?>" data-addr="<?php echo $empl["u_address"] ?>" data-typ="<?php echo $empl["u_type"] ?>"><i class="ri-pencil-line me-1"></i> Edit</a>
                                            <a class="dropdown-item openDelModal" href="#"  data-type="users" data-title="Users" data-delid="<?php echo $empl["u_id"] ?>"><i class="ri-delete-bin-7-line me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Offcanvas to add new user -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Create User</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form id="frmEmply">
                        <input type="hidden" name="action" value="employee">
                        <input type="hidden" name="uId" id="uId">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="txtEmpnm" name="txtEmpnm" placeholder="John Doe" aria-label="John Doe" />
                            <label for="txtEmpnm">Full Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com"  />
                            <label for="txtEmail">Email</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" id="txtMobile" name="txtMobile" class="form-control phone-mask" placeholder="+91 (609) 988-44-11"  />
                            <label for="add-user-contact">Contact</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                        <textarea class="form-control" id="txtAddr" name="txtAddr" placeholder="Enter your Address" style="height: 60px;"></textarea>
                            <label for="txtAddr">Address</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <select class="form-select" name="selType" id="selType">
                                <option selected="">Select</option>
                                <?php
                                $usrobj = new MysqliDb(HOST, USER, PWD, DB);
                                $usrtyarr = $usrobj->get("mv_utype", null, "ut_id,ut_name");
                                foreach ($usrtyarr as $key => $usr) {
                                    echo "<option value='$usr[ut_id]'>$usr[ut_name]</option>";
                                }
                                ?>
                            </select>
                            <label for="user-role">User Role</label>
                        </div>
                        
                        <button type="button" class="btn btn-primary me-sm-3 me-1 data-submit" id="btnEmploy">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                    <div id="emplMsg" class="mt-5"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Change password Modal -->
    <div class="modal fade" id="pwdModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form class="form-horizontal" id="frmEmplyPwd">
                <input type="hidden" name="action" value="changePwd">
                <input type="hidden" name="empIdPwd" id="empIdPwd">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Change Password of <span class="text-red" id="pwdTitle"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-6 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="txtEmpPwd" name="txtEmpPwd" class="form-control" placeholder="Enter New Password">
                                <label for="txtEmpPwd">Password</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-red" id="btnEmployPwd">Save changes</button>
                </div>
            </form>
            <div id="emplPwdMsg"></div>

            </div>
        </div>
    </div>

    <!-- Change password Modal Ends -->
    <?php footer();
scripts();?>
    <script src="<?php echo ROOT ?>plugins/datatables-bs5/datatables-bootstrap5.js"></script>
    <script>
$(function() {
    $(".datatables-users").DataTable({
        dom: '<"row"<"col-md-2 d-flex align-items-center justify-content-md-start justify-content-center"><"col-md-10"<"d-flex align-items-center justify-content-md-end justify-content-center"<"me-4"f><"add-new">>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: {
            sLengthMenu: "Show _MENU_",
            search: "",
            searchPlaceholder: "Search User",
            paginate: {
                next: '<i class="ri-arrow-right-s-line"></i>',
                previous: '<i class="ri-arrow-left-s-line"></i>'
            }
        },
    });
    $(".add-new").html("<button class='btn btn-red waves-effect waves-light' data-bs-toggle='offcanvas' data-bs-target='#offcanvasAddUser'><i class='ri-add-line me-0 me-sm-1 d-inline-block d-sm-none'></i><span class= 'd-none d-sm-inline-block'> Add New User </span ></button>");
    $(document).on("submit", "#frmEmplyPwd", function(frm) {
        frm.preventDefault();
        $.ajax({
            "url": "<?php echo ROOT ?>ajax/user-ajax.php",
            type: 'post',
            data: $("#frmEmplyPwd").serialize(),
            success: function(returnData) {
                // console.log(returnData);	
                try {
                    jsn = $.parseJSON(returnData);
                    if (jsn.status == "done") {
                        location.reload();
                    }
                } catch (exp) {}
            }
        });

    });
    $(document).on("click", "#btnEmploy", function(evt) {
        valid = true;
        $("#emplMsg").html("");
        $("#frmEmply .is-invalid").removeClass("is-invalid");
        if (!$("#txtEmpnm").val()) {
            $("#txtEmpnm").addClass("is-invalid")
            valid = false;
        }
        if (!$("#txtMobile").val()) {
            $("#txtMobile").addClass("is-invalid")
            valid = false;
        }
        if (!$("#txtEmail").val()) {
            $("#txtEmail").addClass("is-invalid")
            valid = false;
        }

        if (!$("#txtAddr").val()) {
            $("#txtAddr").addClass("is-invalid")
            valid = false;
        }
        if (valid) {
            $.ajax({
                "url": "<?php echo ROOT ?>ajax/user-ajax.php",
                type: 'post',
                data: $("#frmEmply").serialize(),
                success: function(returnData) {
                    try {
                        console.log(returnData);
                        resparray = $.parseJSON(returnData)
                        if (resparray.status == "done") {
                            alert = `<div class="alert alert-success" role="alert">User Details added Successfully</div>`;
                            $("#emplMsg").html(alert);
                            location.reload();
                        }
                    } catch (err) {}
                }
            });
        } else {
            alert = `<div class='alert alert-danger alert-dismissible' role='alert'>Please check all inputs<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
            $("#emplMsg").html(alert);
        }
    });
    $('#pwdModal').on('show.bs.modal', function(e) {
        $("#empIdPwd").val($(e.relatedTarget).data('id'));
        $("#pwdTitle").html($(e.relatedTarget).data('title'));
    });
    /*User MODAL*/
    $('#offcanvasAddUser').on('show.bs.offcanvas', function(e) {
        $("#uId").val($(e.relatedTarget).data('id'));
        $("#txtEmpnm").val($(e.relatedTarget).data('title'));
        $("#txtCperson").val($(e.relatedTarget).data('person'));
        $("#txtMobile").val($(e.relatedTarget).data('phone'));
        $("#txtEmail").val($(e.relatedTarget).data('email'));
        $("#txtAddr").val($(e.relatedTarget).data('addr'));
        $("#selType").val($(e.relatedTarget).data('typ'));

        $(".offcanvas-title").html($(e.relatedTarget).data('id') ? "Update User" : "Create User");
    });
    /*User MODAL ENDS*/

});
</script>
</body>
</html>

   