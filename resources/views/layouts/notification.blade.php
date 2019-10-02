<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope"><span class="badge badge-info">{{$notification['count']}}</span></i></a>
    <ul class="dropdown-menu notify-drop">
        <div class="notify-drop-title">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">{{ Auth::user()->name }} (<b>{{ $notification['count'] }}</b>)</div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="tümü okundu."><i class="fa fa-dot-circle-o"></i></a></div>
            </div>
        </div>
        <!-- end notify title -->
        <!-- notify content -->
        <div class="drop-content">
            @foreach ($notification['data'] as $notif)
                <li>
                    <div class="col-md-3 col-sm-3 col-xs-3"><div class="notify-img"><img src="http://placehold.it/45x45" alt=""></div></div>
                    <div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="">Peminjaman Buku Dengan Nomor {{$notif['nomor_peminjaman']}}</a><a href=""> {{ $notif['keterangan'] }} </a> <a href="" class="rIcon"><i class="fa fa-dot-circle-o"></i></a>
                    
                    <hr>
                    Judul Buku Yang dipinjam :
                    @foreach ($notif['buku'] as $buku)
                        <p class="time">{{$buku['title']}}</p>
                        
                    @endforeach
                    </div>
                </li>
            @endforeach
        </div>
        <div class="notify-drop-footer text-center">
            <a href=""><i class="fa fa-eye"></i> See All</a>
        </div>
    </ul>
</li>