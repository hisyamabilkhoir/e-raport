<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-gray-100">
                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-gray-100">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" jika anda yakin</div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" href="<?= base_url(); ?>/auth/logout">Logout</a>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?= base_url('public/'); ?>/AdminLTE/plugins/jquery/jquery.min.js">
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js">
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/dist/js/adminlte.min.js">
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js">
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
</script>
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/jss/sweetalert2.all.min.js">
</script>
<script src="<?= base_url('public/'); ?>/AdminLTE/jss/myscript.js">
</script>

</body>

</html>