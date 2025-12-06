<!--pagination start-->
    <div class="pagination-btn">
        {{-- <ul class="page-numbers">
            <li><a href="#" class="next page-numbers"><i class="zmdi zmdi-long-arrow-left"></i></a></li>
            <li><span class="page-numbers current">1</span></li>
            <li><a href="#" class="page-numbers">2</a></li>
            <li><a href="#" class="page-numbers">3</a></li>
            <li><a href="#" class="next page-numbers"><i class="zmdi zmdi-long-arrow-right"></i></a></li>
        </ul> --}}
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
    <!--pagination end-->