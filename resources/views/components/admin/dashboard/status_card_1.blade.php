<div class="card-box">

    <h4 class="header-title mt-0 mb-3">{{ $title }}</h4>

    <div class="widget-box-2">
        <div class="widget-detail-2 text-right">
            @isset($icon)
                <span class="float-left mt-3 widget-icon">
                    <i class="mdi mdi-{{ $icon }}"></i>
                </span>
            @endisset
            <h2 class="font-weight-normal mb-1"> {{ $count }} </h2>
            <p class="text-muted mb-3">{{ $subTitle }}</p>
        </div>
    </div>
</div>