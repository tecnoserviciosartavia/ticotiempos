@if (session($key ?? 'success'))
     <!-- BEGIN: Notification Content -->
    <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
        <div class="ml-4 mr-4">
            <div class="font-medium">Guardado Correctamente!</div>
            <div class="text-slate-500 mt-1">{{ session($key ?? 'success') }}</div>
        </div>
    </div> <!-- END: Notification Content -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        Toastify({ node: $("#success-notification-content") .clone() .removeClass("hidden")[0], duration: -1, newWindow: true, close: true, gravity: "top", position: "right", stopOnFocus: true, }).showToast();
    </script>
@endif
