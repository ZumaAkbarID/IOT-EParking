@forelse ($business as $item)
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-content">
                <img class="card-img-top img-fluid" src="{{ asset('/storage') . '/' . $item->business_thumbnail }}"
                    alt="Card image cap" style="height: 20rem" />
                <div class="card-body">
                    <h4 class="card-title">{{ $item->business_name }}</h4>
                    <p class="card-text text-truncate">
                        {{ $item->business_description }}
                    </p>
                    <p class="card-text text-truncate">
                        {{ $item->business_address }}
                    </p>
                    <a href="{{ route('Search', $item->uuid) }}" class="btn btn-primary block">Periksa
                        Parkiran</a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="card mt-5">
        <div class="card-body">
            <p class="">Lokasi tidak ditemukan</p>
        </div>
    </div>
@endforelse
