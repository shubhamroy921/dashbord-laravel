   <script>
       $(document).ready(function() {
           toastr.options = {
               "closeButton": true,
               "debug": false,
               "newestOnTop": true,
               "progressBar": true,
               "positionClass": "toast-top-right",
               "preventDuplicates": false,
               "onclick": null,
               "showDuration": "300",
               "hideDuration": "1000",
               "timeOut": "5000",
               "extendedTimeOut": "1000",
               "showEasing": "swing",
               "hideEasing": "linear",
               "showMethod": "fadeIn",
               "hideMethod": "fadeOut"
           };

           @if (session('success'))
               toastr.success('{{ session('success') }}');
           @endif

           // Check for validation errors
           @if ($errors->any())
               // Loop through each error and show as Toastr error message
               @foreach ($errors->all() as $error)
                   toastr.error("{!! $error !!}");
               @endforeach
           @endif

           @if (session('error'))
               toastr.error('{{ session('error') }}');
           @endif
       });
   </script>
   <footer class="footer pt-3  ">
       <div class="container-fluid">
           <div class="row align-items-center justify-content-lg-between">
               <div class="col-lg-6 mb-lg-0 mb-4">
                   <div class="copyright text-center text-sm text-muted text-lg-start">
                       ©
                       <script>
                           document.write(new Date().getFullYear())
                       </script>, made with <i class="fa fa-heart"></i> by
                       <a href="#" class="font-weight-bold" target="_blank">Shubham Roy</a> &amp; <a
                           style="color: #252f40;" href="https://www.updivision.com" class="font-weight-bold ml-1"
                           target="_blank">UPDIVISION</a>
                       for a better web.
                   </div>
               </div>
               <div class="col-lg-6">
                   <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                       <li class="nav-item">
                           <a href="#" class="nav-link text-muted" target="_blank">Creative Tim</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link text-muted" target="_blank">UPDIVISION</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link text-muted" target="_blank">About Us</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link text-muted" target="_blank">Blog</a>
                       </li>
                       <li class="nav-item">
                           <a href="#" class="nav-link pe-0 text-muted" target="_blank">License</a>
                       </li>
                   </ul>
               </div>
           </div>
       </div>
   </footer>
