

<script src="/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>

<script src="/js/notify.min.js"
    integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@if (session()->has('success'))
    <script type="text/javascript">
        $(document).ready(function() {
            $.notify('{{ session('success') }}', 'success');
        });
    </script>
@endif

@if (session()->has('failed'))
    <script type="text/javascript">
        $(document).ready(function() {
            $.notify('{!! session('failed') !!}', 'error');
        });
    </script>
@endif
