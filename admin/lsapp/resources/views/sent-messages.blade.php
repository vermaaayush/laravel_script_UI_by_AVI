@include('header')



            <!-- partial -->

            <div class="main-panel">

                <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">

                            <span class="page-title-icon bg-gradient-primary text-white mr-2">

                                <i class="mdi mdi-send"></i>

                            </span> Sent Messages <h3>

                        </h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Support</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Sent Messages </li>

                            </ol>

                        </nav>

                    </div>



                    <div class="row">



                        <div class="col-lg-12 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')

                                    <h4 class="card-title">All Sent Messages</h4>

                                    </p>

                                    <table class="table table-dark table-hover">

                                        <thead>

                                            <tr>

                                                <!-- <th style="width: 5vh;"> #</th> -->

                                                <th style="width: 50vh;"> Type </th>

                                                <th style="width: 50vh;"> Date </th>

                                                <th style="width: 50vh;"> Recipient </th>

                                                <th style="width: 50vh;"> Subject </th>

                                                <th> Message </th>

                                                <th style="width: 40vh;"> # </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($sentMessages as $message)

                                            <tr>

                                                <!-- <td>

                                                    <div class="form-check">

                                                        <label class="form-check-label">

                                                            <input type="checkbox" class="form-check-input"> &nbsp; <i

                                                                class="input-helper"></i></label>

                                                    </div>

                                                </td> -->

                                                <td> {{ ucfirst($message->type) }} </td>

                                                <td> {{ $message->date }} </td>

                                                <td> 

                                                    @if($message->type == 'push')
                                                        @if($message->receiver == 'all')
                                                            All
                                                        @else
                                                            Specific
                                                        @endif
                                                    @else
                                                        {{ $message->receiver }}
                                                    @endif

                                                </td>

                                                <td> {{ $message->subject }} </td>

                                                <td> {{ $message->msg }} </td>

                                                <td>

                                                    <a href="{{ asset('view-message/' . $message->id) }}">

                                                        <button type="button" class="btn btn-primary btn-icon ">

                                                            <i class="mdi mdi-eye"></i>

                                                        </button>

                                                    </a>

                                                    <a href="{{ asset('delete-message/' . $message->id) }}">

                                                        <button type="button" class="btn btn-danger btn-icon">

                                                            <i class="mdi mdi-delete-forever"></i>

                                                        </button>

                                                    </a>

                                                </td>

                                            </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>



                    </div>

                </div>

                <!-- content-wrapper ends -->





                @include('footer')

                <!-- partial -->

            </div>

            <!-- main-panel ends -->

        </div>

        <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->





















































    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- plugins:js -->

    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- endinject -->

    <!-- Plugin js for this page -->

    <!-- End plugin js for this page -->

    <!-- inject:js -->

    <script src="{{ asset('js/off-canvas.js') }}"></script>

    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>

    <script src="{{ asset('js/misc.js') }}"></script>

    <!-- endinject -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>

</body>



</html>