@include('includes.admin.layout.head')
@include('includes.admin.layout.header')
@include('includes.admin.layout.sidebar')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('page')</h1>
                </div>
                
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @foreach ($breadcrumbs as $label => $url)
                            @if ($loop->last)
                                <li class="breadcrumb-item active">{{ $label }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $url }}">{{ $label }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @yield('content')
    <!-- GLOBAL IMAGE VIEWER MODAL -->
    <div class="modal fade" id="imageViewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-center">
                <img id="imageViewModalImg" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@include('includes.admin.layout.footer')
