@if (Session::has('success'))
<div id="alert" class="alert alert-primary">
    {{Session::get('success')}}
</div>
<script>
    $(function(){
        setTimeout(function() {
            $('alert').slideUp();
        }, 5000);
    });
    </script>
@endif