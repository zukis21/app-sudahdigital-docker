@if($param_typeAll == 1)
    <div class="col-md-12 mb-4" data-aos="fade-up">
        <div class="box w-100">
        <ul class="list-group w-100" style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);border-top-right-radius:20px;
            border-top-left-radius:20px;">
            <li class="list-group-item active" 
                style="background-color:#1A4066;
                        border-top-right-radius:20px;
                        border-top-left-radius:20px;
                        border-color:#1A4066;
                        color:#fff;">
            <i class="fal fa-chart-bar py-1 mr-2"
            style="border-radius:5px;float: left;padding-left:6px;padding-right:6px;"></i>
            <span class="font-weight-bold dashboard-tittle" style="display: block; padding-left: 40px;">Grafik Pencapaian Kuantitas <!--{{date('F Y', strtotime(\Carbon\Carbon::now()))}}--></span>
            </li>
            <li class="list-group-item" style="color: #1A4066;">
            <div id="container_qty" class="height-chart"></div>
            </li>
        </ul>
        </div>
    </div>
@endif