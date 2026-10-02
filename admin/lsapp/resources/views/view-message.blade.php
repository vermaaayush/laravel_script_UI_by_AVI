@include('header')


            <!-- partial -->

            <div class="main-panel">

                <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">

                            <span class="page-title-icon bg-gradient-primary text-white mr-2">

                                <i class="mdi mdi-eye"></i>

                            </span> View Message </h3>

                        </h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Support</a></li>

                                <li class="breadcrumb-item active" aria-current="page">View Message </li>

                            </ol>

                        </nav>

                    </div>



                    <div class="row">



                        <div class="col-lg-12 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">

                                    <div class="form-group">

                                        <label for="exampleInputCity1">Type</label>
                                        <p>
                                        @if($message[0]->type == 'sms')
                                            SMS
                                        @elseif($message[0]->type == 'push')
                                            Push Notification
                                        @else
                                            Email
                                        @endif
                                        </p>
                                    </div>

                                    <div class="form-group">

                                        <label for="exampleInputCity1">Date</label>

                                        <input type="text" class="form-control" id="exampleInputCity1"

                                            placeholder="Recipient" value="{{ $message[0]->date }}" disabled>

                                    </div>

                                    @if($message[0]->type != 'push')

                                    <div class="form-group">

                                        <label for="exampleInputCity1">Recipient</label>

                                        <input type="text" class="form-control" id="exampleInputCity1"

                                            placeholder="Recipient" value="{{ $message[0]->receiver }}" disabled>

                                    </div>

                                    @else

                                    @if($message[0]->receiver == 'all')

                                    <div class="form-group">

                                        <label for="exampleInputCity1">Recipient</label>

                                        <input type="text" class="form-control" id="exampleInputCity1"

                                            placeholder="Recipient" value="All" disabled>

                                    </div>

                                    @else

                                    <div class="form-group">

                                        <label for="exampleInputCity1">Recipient</label>

                                        <input type="text" class="form-control" id="exampleInputCity1"

                                            placeholder="Recipient" value="{{ $receivers[0]->name }}" disabled>

                                    </div>

                                    @endif

                                    @endif

                                    @if($message[0]->type == 'email')

                                    <div class="form-group">

                                        <label for="exampleInputCity1">Subject</label>

                                        <input type="text" class="form-control" id="exampleInputCity1"

                                            placeholder="Subject" value="{{ $message[0]->subject }}" disabled>

                                    </div>

                                    @endif

                                    <div class="form-group">

                                        <label for="exampleTextarea1">Message</label>

                                        <textarea class="form-control" id="exampleTextarea1" rows="4"

                                            value="" style="min-height: 50vh;" disabled>{{ $message[0]->msg }}</textarea>

                                    </div>

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