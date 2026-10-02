@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Page Popups</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Cms Section</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Page Popups</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <?php if(isset($_GET['type']) && $_GET['type'] == 'add'){ ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @include('flash::message')
                                                <h4 class="card-title">Add Page Popup</h4>
                                                <p class="card-description"></p>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3 stretch">
                                                
                                            </div>
                                        </div>
                                        <form action="pop_pages_save" method="POST" class="forms-sample" enctype="multipart/form-data">
                                            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Title</label>
                                                <input type="text" class="form-control" name="title" required value="" placeholder="Title" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Content</label>
                                                <textarea type="text" class="form-control" id="editor" name="content" required value="" placeholder="Content"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-gradient-primary mr-2">Save</button>
                                            <a href="{{ asset('pop_pages')}}" class="btn btn-light">Cancel</a>
                                        </form>
                                    <?php }else if(isset($_GET['id']) && $_GET['id'] != ''){ ?>
                                        <?php $sing = DB::table('ba_pop_pages')->where('id',$_GET['id'])->first(); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @include('flash::message')
                                                <h4 class="card-title">Edit Page Popup</h4>
                                                <p class="card-description"></p>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3 stretch">
                                                
                                            </div>
                                        </div>
                                        <form action="pop_pages_update" method="POST" class="forms-sample" enctype="multipart/form-data">
                                            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                            <input type = "hidden" name = "id" value = "<?= $sing->id ?>">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Title</label>
                                                <input type="text" class="form-control" name="title" required value="<?= $sing->title ?>" placeholder="Title" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Content</label>
                                                <textarea type="text" class="form-control" id="editor" name="content" required value="" placeholder="Content"><?= $sing->content ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                                            <a href="{{ asset('pop_pages')}}" class="btn btn-light">Cancel</a>
                                        </form>
                                    <?php }else{ ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                @include('flash::message')
                                                <h4 class="card-title">List of Page Popups</h4>
                                                <p class="card-description"></p>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3 stretch">
                                                <a href="{{ asset('pop_pages?type=add')}}"
                                                    style="color: white;  text-decoration: none;"> <button type="button"
                                                        class="btn btn-success btn-lg"
                                                        style="font-size: smaller;">Add Popup</button>
                                                </a>
                                            </div>
                                        </div>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($list as $branch)
                                                <tr>
                                                    <td> {{ $branch->title }} </td>
    
                                                    <td>
                                                        <a href="pop_pages?id={{$branch->id}}"
                                                            style="color: white;  text-decoration: none;"> <button
                                                                type="button" class="btn btn-info btn-sm"
                                                                style="font-size: smaller;">VIEW/EDIT</button>
                                                        </a>
                                                        <a href="pop_pages_delete/{{$branch->id}}"
                                                            style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
                                                            style="font-size: smaller;">DELETE</button></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    <?php } ?>
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


    <script src="js/jquery-3.5.1.min.js"></script>
    
    
    <script src="<?= asset('exasset/ckeditor/ckeditor.js') ?>"></script>

    <script type="text/javascript">
    	var toolbarGroups = [
    	    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    	    { name: 'forms', groups: [ 'forms' ] },
    	    '/',
    	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    	    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    	    '/',
    	    { name: 'styles', groups: [ 'styles' ] },
    	    { name: 'colors', groups: [ 'colors' ] },
    	    { name: 'tools', groups: [ 'tools' ] },
    	    { name: 'others', groups: [ 'others' ] }
    	];
        CKEDITOR.replace( 'editor',{
    	    toolbar : 'Basic',
    	    toolbarGroups,
       	});
    </script>
    
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <!-- endinject -->
</body>

</html>