@include('header')

<div class="main-panel">
    <div class="content-wrapper">
        @include('flash::message')
        
        <div class="row">
            <div class="col-12 grid-margin">
                <form method="post" action="clear-table">
                {{--<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">--}}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Select Table Which You want to clear form Database</h4>
                        <p id="textBtcSendCard" style="color:red;"></p>
                                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Tables</label>
                                    <select name="table_name" id="card_type" class="form-control" required>
                                        <option disabled selected>-- Select --</option>
                                        @foreach ($tables_in_db as $table_in_db)
                                            <option value="{{$table_in_db->Tables_in_lcuslisj_DB1}}">{{$table_in_db->Tables_in_lcuslisj_DB1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Clear</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                </form>
            </div>
      
        
    @include('footer')
</div>
</div>
<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('js/misc.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/todolist.js') }}"></script>
<!-- End custom js for this page -->

</body>
</html>