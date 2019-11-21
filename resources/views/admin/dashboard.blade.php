@extends('admin/admin')

@section('active-page', 'Dashboard')

@section('content')
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-images"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Data Images</span>
                <span class="info-box-number">
                    {{ isset($totalImage) ? $totalImage : '0' }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Members</span>
                <span class="info-box-number">
                    {{ isset($totalMember) ? $totalMember : '0' }}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
@endsection
