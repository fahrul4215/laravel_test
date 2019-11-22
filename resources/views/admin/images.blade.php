@extends('admin/admin')

@section('meta')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <style>
        .uploader {
            display: block;
            clear: both;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
        }
        .uploader .label-image {
            float: left;
            clear: both;
            width: 100%;
            padding: 2rem 1.5rem;
            text-align: center;
            background: #fff;
            border-radius: 7px;
            border: 3px solid #eee;
            transition: all .2s ease;
            user-select: none;
        }
        .uploader .label-image:hover {
            border-color: #454cad;
        }
        .uploader .label-image.hover {
            border: 3px solid #454cad;
            box-shadow: inset 0 0 0 6px #eee;
        }
        .uploader .label-image.hover #start i.fa {
            transform: scale(0.8);
            opacity: 0.3;
        }
        .uploader #start {
            float: left;
            clear: both;
            width: 100%;
        }
        .uploader #start.hidden {
            display: none;
        }
        .uploader #start i.fa {
            font-size: 50px;
            margin-bottom: 1rem;
            transition: all .2s ease-in-out;
        }
        .uploader #response {
            float: left;
            clear: both;
            width: 100%;
        }
        .uploader #response.hidden {
            display: none;
        }
        .uploader #response #messages {
            margin-bottom: .5rem;
        }
        .uploader #file-image {
            display: inline;
            margin: 0 auto .5rem auto;
            width: auto;
            height: auto;
            max-width: 180px;
        }
        .uploader #file-image.hidden {
            display: none;
        }
        .uploader #notimage {
            display: block;
            float: left;
            clear: both;
            width: 100%;
        }
        .uploader #notimage.hidden {
            display: none;
        }
        .uploader progress,
        .uploader .progress {
            display: inline;
            clear: both;
            margin: 0 auto;
            width: 100%;
            max-width: 180px;
            height: 8px;
            border: 0;
            border-radius: 4px;
            background-color: #eee;
            overflow: hidden;
        }
        .uploader .progress[value]::-webkit-progress-bar {
            border-radius: 4px;
            background-color: #eee;
        }
        .uploader .progress[value]::-webkit-progress-value {
            background: linear-gradient(to right, #393f90 0%, #454cad 50%);
            border-radius: 4px;
        }
        .uploader .progress[value]::-moz-progress-bar {
            background: linear-gradient(to right, #393f90 0%, #454cad 50%);
            border-radius: 4px;
        }
        .uploader input[type="file"] {
            display: none;
        }
        .uploader .btn-upload {
            display: inline-block;
            margin: .5rem .5rem 1rem .5rem;
            clear: both;
            font-family: inherit;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            text-transform: initial;
            border: none;
            border-radius: .2rem;
            outline: none;
            padding: 0 1rem;
            height: 36px;
            line-height: 36px;
            color: #fff;
            transition: all 0.2s ease-in-out;
            box-sizing: border-box;
            background: #454cad;
            border-color: #454cad;
            cursor: pointer;
        }
        .text-danger{
            color: red;
        }
    </style>
@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('lte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    {{-- Validate --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <!-- page script -->
    <script>
        var SITE_URL = '{{ URL::to('/admin') }}'
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#dt-images").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: SITE_URL + "/images",
                    type: 'GET',
                },
                columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'image', name: 'image', render: getImage},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'desc']],
                columnDefs: [
                    {
                        targets: [1, 3, 4, 5],
                        className: 'text-center'
                    }
                ]
            });

            function getImage(data, type, full, meta) {
                data = (data == '') ? 'no-image.png' : data;
                return '<img width="200" src="{{ asset('images') }}/'+data+'"/>';
            }
        });

        $(function() {
            $('#create-new-data').click(function () {
                $('#btn-save').val("create-data-image");
                $('#image_id').val('');
                $('#file-upload').val('');
                resetImageFormData();
                $('#data-form').trigger("reset");
                $('#ajax-modal-title').html("Add New Data");
                $('#ajax-modal').modal("show");
            });

            /* When click edit user */
            $('body').on('click', '.edit-data', function () {
                var data_id = $(this).data('id');
                $.get(SITE_URL + '/images/' + data_id +'/edit', function (data) {
                    $('#ajax-modal-title').html("Edit data");
                    $('#btn-save').val("edit-data");
                    $('#ajax-modal').modal('show');
                    $('#image_id').val(data.id);
                    $('#title').val(data.title);
                    loadImage(data.image);
                    $("input[data-bootstrap-switch]").bootstrapSwitch('state', (data.status == 'on') ? true : false);
                })
            });

            $('body').on('click', '#delete-data', function () {
                var data_id = $(this).data("id");
                if(confirm("Are You sure want to delete???")){
                    $.ajax({
                        type: "get",
                        url: SITE_URL + "/images/delete/"+ data_id,
                        success: function (data) {
                            var oTable = $('#dt-images').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });

            $("input[data-bootstrap-switch]").each(function(){
                var s = false;
                $(this).bootstrapSwitch('state', s);
                $('#status').prop('checked', s);
                $('#val-status').val((s) ? 'on' : 'off');

                $(this).on('switchChange.bootstrapSwitch', function (e, state) {
                    e.preventDefault();
                    $('#val-status').val((state) ? 'on' : 'off');
                })
            });

        });

        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

        function SuccessToast(data) {
            Toast.fire({
                type: 'success',
                title: 'Successfully ' + data
            })
        };

        function readURL(input, id) {
            id = id || '#file-image';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id).attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
                $('#file-image').removeClass('hidden');
                $('#start').hide();
            }
        };

        function loadImage(imageName) {
            if (imageName == '') {
                resetImageFormData();
                return;
            }
            $('#file-image').attr('src', '{{ asset('images') }}'+'/'+imageName);
            $('#image-name').val(imageName);
            $('#file-image').removeClass('hidden');
            $('#start').hide();
        }

        function resetImageFormData() {
            $('#error-text').html('');
            $('#file-image').addClass('hidden');
            $('#start').show();
        }

        if ($("#data-form").length > 0) {
            $("#data-form").validate({
                submitHandler: function(form) {
                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Sending..');

                    $.ajax({
                        data: new FormData(form),
                        url: SITE_URL + "/images/store",
                        type: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#data-form').trigger("reset");
                            $('#ajax-modal').modal('hide');
                            $('#btn-save').html('Save Changes');
                            var oTable = $('#dt-images').dataTable();
                            oTable.fnDraw(false);
                            SuccessToast((actionType == 'edit-data') ? 'Edited' : 'Added');
                        },
                        error: function (data) {
                            console.log("Error:", data);
                            resetImageFormData();
                            $('#error-text').html(data.responseJSON.errors.fileUpload);
                            $('#btn-save').html('Save Changes');
                        }
                    });
                }
            })
        }
    </script>
@endsection

@section('active-page', 'Data Images')

@section('content')
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <button type="button" id="create-new-data" class="btn btn-primary">
                Add Image
            </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dt-images" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>No</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    @endsection

    @section('modal')
    <!-- Modal -->
    <div class="modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajax-modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="data-form" class="uploader" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image_id" id="image_id">
                        <input type="hidden" name="status" id="val-status">
                        <input type="hidden" name="image_name" id="image-name">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" minlength="5" maxlength="30" required>
                        </div>
                        <div class="form-group">
                            <input id="file-upload" type="file" name="fileUpload" accept="image/png,image/gif,image/jpeg" onchange="readURL(this);">
                            <label for="file-upload" id="file-drag" class="label-image">
                                <img id="file-image" src="#" alt="Preview" class="hidden">
                                <div id="start" >
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <div>Select your Image</div>
                                    <div id="notimage" class="hidden">Please select an image</div>
                                    <span id="file-upload-btn" class="btn btn-primary btn-upload">Select a file</span>
                                    <br>
                                    <span id="error-text" class="text-danger">{{ $errors->first('fileUpload') }}</span>
                                </div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <br>
                            <input type="checkbox" id="status" data-bootstrap-switch>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn-save">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
