        </div>
        <!-- end main content-->
    </div>
<!-- END layout-wrapper -->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="bi bi-arrow-up-circle-fill"></i>
</button>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/waves.min.js"></script>
<script src="js/feather.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/dashboard-ecommerce.init.js"></script>
<script src="js/chart.umd.js"></script>
<script src="js/chartjs.init.js"></script>
<script src="js/app.js"></script>
<script src="js/fonticons.js"></script>
<script src="include/select2/js/select2.min.js"></script>
<script src="include/select2/js/select.js"></script>
<script src="include/js/common.js"></script>
<script src="include/js/keyboard_control.js"></script>
<script src="js/datatables/datatables.min.js"></script>
<script src="include/js/datatable_functions.js"></script>
<script>
    $(document).on('select2:open', function() {
        setTimeout(() => {
            let searchField = document.querySelector('.select2-container--open .select2-search__field');
            if (searchField) {
                searchField.focus();
            }
        }, 0);
    });
</script>
<script type="text/javascript" src="include/js/countries.js"></script>
<script type="text/javascript" src="include/js/cities.js"></script>
<script type="text/javascript" src="include/js/district.js"></script>
<script type="text/javascript" src="include/js/xlsx.full.min.js"></script>
</body>
</html>
<?php include "modal_content.php"; ?>
