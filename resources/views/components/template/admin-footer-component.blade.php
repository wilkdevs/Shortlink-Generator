        {{--  <footer class="footer py-4">
            <div class="pull-right">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>
                <a href="">Gak Kreatif Kok</a>, <span>Make life difficult with our mobile app in your hand</span>
            </div>
            <div class="clearfix"></div>
        </footer>  --}}
    </div>
</main>

<!--   Core JS Files   -->
<script src="/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="/assets/js/core/popper.min.js"></script>
<script src="/assets/js/core/bootstrap.min.js"></script>
<script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/assets/js/plugins/datatables.js"></script>

<script src="/assets/js/plugins/choices.min.js"></script>
<script src="/assets/js/plugins/dropzone.min.js"></script>
<script src="/assets/js/plugins/quill.min.js"></script>
<script src="/assets/js/plugins/multistep-form.js"></script>

<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  var options = {
    damping: '0.5'
  }
  Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>
<!-- Github buttons -->
<script async defer src="/js/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/assets/js/material-dashboard.min.js?v=3.0.3"></script>
{{-- <!--  Notifications Plugin    --> --}}
<script src="/js/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Kanban scripts -->
<script src="/assets/js/plugins/dragula/dragula.min.js"></script>
<script src="/assets/js/plugins/jkanban/jkanban.js"></script>

@if(session()->has('success'))
    <script type="text/javascript">
        $(document).ready(function() {
            $.notify('{{ session('success') }}', 'success');
        });
    </script>
@endif

@if(session()->has('failed'))
    <script type="text/javascript">
        $(document).ready(function() {
            $.notify('{{ session('failed') }}', 'error');
        });
    </script>
@endif
