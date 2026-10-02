@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Language Control</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Support Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Language Control</li>
                            </ol>
                        </nav>
                    </div> 

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                     @include('flash::message')
                                      <div class="row">
                                       
                                        <div class="col-md-3 stretch">
                                           
                                        </div>
                                        

                                        
                                    </div><br><br>
                                     
                                
                                <form class="form-inline" method="POST" action="{{ url('language_control_update') }}">
    @csrf
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Language</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Ivr_Msg as $msg)
            <tr>
                <td>{{ $msg->language }}</td>
                <td>
                    <input type="hidden" name="ids[]" value="{{ $msg->id }}">
                    
                    <div class="form-group mx-sm-3 mb-2">
                        <input class="form-check-input" type="radio" name="status_{{ $msg->id }}" id="status_disable_{{ $msg->id }}" value="0" {{ $msg->status == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_disable_{{ $msg->id }}">
                            Disable
                        </label>
                    </div>
                    
                    <div class="form-group mx-sm-3 mb-2">
                        <input class="form-check-input" type="radio" name="status_{{ $msg->id }}" id="status_enable_{{ $msg->id }}" value="1" {{ $msg->status == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_enable_{{ $msg->id }}">
                            Enable
                        </label>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary btn-lg" style="padding:10px 13px !important;">Update</button>
</form>

                                </div>
                                <div class="pages" style="position: relative;left: 415px;">
                               
                           </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->

@include('footer_2')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>