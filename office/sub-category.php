<?php
include("template.php");
head("Sub Category List");
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
                <h5 class="card-title mb-0">Sub Category List</h5>
            </div>
            <div class="card-datatable table-responsive">
                <?php
                $itmcatobj = new MysqliDb(HOST, USER, PWD, DB);
                $itmcatobj->where("sct_status",0);
                $itmcatobj->join("tbl_category ct","ct.ct_id=sct.ct_id");
                $itmcategory = $itmcatobj->get("tbl_sub_category sct", null, "sct_id,sct_title,ct.ct_title,sct_status");
                ?>
                <table class="datatables-usertype table">
                    <thead>
                        <tr>
                            <th>si no</th>
                            <th>Sub Category</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($itmcategory as $key => $cat) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $cat["sct_title"] ?></td>
                                <td><?php echo $cat["ct_title"] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item openOffcanvas" href="#" data-toggle="offcanvas"  data-id="<?php echo $cat["sct_id"] ?>" data-name="<?php echo $cat["sct_title"] ?>" data-cat="<?php echo $cat["ct_title"] ?>"><i class="ri-pencil-line me-1"></i> Edit</a>
                                            <a class="dropdown-item openDelModal" href="#" data-title="Item category" data-type="subcategory" data-delid="<?php echo $cat["sct_id"] ?>"><i class="ri-delete-bin-7-line me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                           
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <!-- Offcanvas to add new user -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasItemCategory" aria-labelledby="offcanvasItemCategoryLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasItemCategoryLabel" class="offcanvas-title">Add Category</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                    <form class="add-new-user pt-0" id="frmItmCat">
                        <input type="hidden" name="action" value="addSubCategory">
                        <input type="hidden" name="catId" id="catId">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="txtCatname" name="txtCatname" placeholder="Sub Category Title" />
                            <label for="txtCatname">Sub Category Name</label>
                        </div>
                         <div class="form-floating form-floating-outline mb-5">
                           <select class="form-select required" name="selCatgry" id="selCatgry">
                      <option value="">Select</option>
                        <?php
                        $catobj = new MysqliDb(HOST, USER, PWD, DB);
                        $catarr = $catobj->get("tbl_category", null, "ct_id,ct_title");
                        foreach ($catarr as $key => $cat) {
                            echo "<option value='$cat[ct_id]'>$cat[ct_title]</option>";
                        }
                        ?>
                    </select>
                    <label for="selCatgry">Category</label>
                        </div>
                        <button type="button" class="btn btn-red me-sm-3 me-1 data-submit" id="btnUpdate">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                    <div id="errMsg" class="mt-5"></div>

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
            pageLength: 30,
            dom: '<"row"<"col-md-2 d-flex align-items-center justify-content-md-start justify-content-center"><"col-md-10"<"d-flex align-items-center justify-content-md-end justify-content-center"<"me-4"f><"add-new">>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Category",
                paginate: {
                    next: '<i class="ri-arrow-right-s-line"></i>',
                    previous: '<i class="ri-arrow-left-s-line"></i>'
                }
            },

        });
        $(".add-new").html("<button class='btn btn-red waves-effect waves-light' data-bs-toggle='offcanvas' data-bs-target='#offcanvasItemCategory'><i class='ri-add-line me-0 me-sm-1 d-inline-block d-sm-none'></i><span class= 'd-none d-sm-inline-block'>Create Category</span ></button>")
        $(document).on("click", "#btnUpdate", function(evt) {
            valid = true;
            $("#errMsg").html("");
        
            $("#frmItmCat .is-invalid").removeClass("is-invalid");
            if (!$("#txtCatname").val()) {
                $("#txtCatname").addClass("is-invalid")
                valid = false;
            }
            if (!$("#selCatgry").val()) {
                $("#selCatgry").addClass("is-invalid")
                valid = false;selCatgry
            }
            if (valid) {
                $.ajax({
                    url: "<?php echo ROOT ?>ajax/category-ajax.php",
                    type: 'POST',
                    data: $("#frmItmCat").serialize(),
                    success: function(returnData) {
                        try {
                            resparray = $.parseJSON(returnData)
                            if (resparray.status == "done") {
                                alert = `<div class="alert alert-success" role="alert">Sub Category Details added Successfully</div>`;
                            $("#errMsg").html(alert);
                                location.reload();
                            }
                        } catch (err) {}
                    }
                });
            } else {
                alert = `<div class='alert alert-danger alert-dismissible' role='alert'>Please check all inputs<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
            $("#errMsg").html(alert);
            }
        });
        
        $(document).on("click",".openOffcanvas",function(cnv){
            cnv.preventDefault();
            $("#catId").val($(this).data('id'));
            $("#txtCatname").val($(this).data('name'));
            $("#selCatgry").val($(this).data('cat'));
            $(".offcanvas-title").html($(this).data('id') ? "Update Category" : "Create Category");
            $('#offcanvasItemCategory').offcanvas("show"); 
        });
       
    });
</script>
</body>
</html>

    
