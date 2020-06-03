<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
        <div class="p-4" style="height: 200vh;">
            <h1><a href="index.html" class="logo">{{Auth::user()->name}} <span>{{Auth::user()->status}}</span></a></h1>
            @if (Auth::user()->status == "Pelamar")
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="#" style="font-size: 20px;"><span class="fa fa-file mr-3"></span> Daftar Lowongan Kerja</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-tasks mr-3"></span> Progres Tes Rekrutmen</a>
                </li>
            </ul>
            @elseif (Auth::user()->status == "Perusahaan")
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="/kerjasamaRekrutmen/{{Auth::user()->id}}"><span class="fa fa-file mr-3"></span> Kerjasama Rekrutmen</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-tasks mr-3"></span> Progres Tes Rekrutmen</a>
                </li>
            </ul>
            @elseif (Auth::user()->status == "UPKK")
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="{{route('kerjasamaRekrutmenUpkk')}}"><span class="fa fa-file mr-3"></span> Daftar Kerjasama Rekrutmen</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-tasks mr-3"></span> Progres Tes Rekrutmen</a>
                </li>
            </ul>
            @endif
        </div>
    </nav>