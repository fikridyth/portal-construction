<x-app-layout :pageHeader="$pageHeader" :assets="$assets ?? []" :dir="false">
    <div class="row">
        <div class="col-md-12 col-lg-12 mt-3">
            <div class="card" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center text-primary">
                            <h4 class="text-secondary"><a href="{{ route('approval.index') }}">Approval</a></h4>
                        </div>
                    </div>
                </div>
                <div style="width: 97%; margin: 0 auto;">
                    <div class="row row-cols-1 mt-4">
                        <div class="d-slider1 overflow-hidden ">
                            <ul class="swiper-wrapper list-inline m-0 p-0 mb-2">
                                <div class="me-2" style="width: 320px;">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body d-flex justify-content-center align-items-center bg-light rounded" style="height: 100px;">
                                            <div class="progress-widget">
                                                <i class="fas fa-marker fa-2x"></i>
                                                <div class="progress-detail">
                                                    <h6 class="mb-2">Approval Manager</h6>
                                                    <h4 class="counter" style="visibility: visible;">{{ $manager }} Order</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="mx-2" style="width: 300px;">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body d-flex justify-content-center align-items-center bg-light rounded" style="height: 100px;">
                                            <div class="progress-widget">
                                                <i class="fas fa-business-time fa-2x"></i>
                                                <div class="progress-detail">
                                                    <h6 class="mb-2">Approval Owner</h6>
                                                    <h4 class="counter" style="visibility: visible;">{{ $owner }} Order</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="mx-2" style="width: 320px;">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body d-flex justify-content-center align-items-center bg-light rounded" style="height: 100px;">
                                            <div class="progress-widget">
                                                <i class="fas fa-cash-register fa-2x"></i>
                                                <div class="progress-detail">
                                                    <h6 class="mb-2">Pembayaran Finance</h6>
                                                    <h4 class="counter" style="visibility: visible;">{{ $finance }} Order</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="mx-2" style="width: 280px;">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body d-flex justify-content-center align-items-center bg-light rounded" style="height: 100px;">
                                            <div class="progress-widget">
                                                <i class="fas fa-rectangle-xmark fa-2x"></i>
                                                <div class="progress-detail">
                                                    <h6 class="mb-2">Order Ditolak</h6>
                                                    <h4 class="counter" style="visibility: visible;">{{ $ditolak }} Order</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="ms-2" style="width: 280px;">
                                    <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                        <div class="card-body d-flex justify-content-center align-items-center bg-light rounded" style="height: 100px;">
                                            <div class="progress-widget">
                                                <i class="fas fa-square-check fa-2x"></i>
                                                <div class="progress-detail">
                                                    <h6 class="mb-2">Order Disetujui</h6>
                                                    <h4 class="counter" style="visibility: visible;">{{ $disetujui }} Order</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                            </ul>
                            <div class="swiper-button swiper-button-next"></div>
                            <div class="swiper-button swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12">
            <div class="row">
                @if($dataMingguan)
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center text-primary">
                                        <h4 class="text-secondary"><a href="{{ route('laporan-mingguan.index') }}">Laporan Mingguan</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header d-flex justify-content-between flex-wrap">
                                <div class="header-title">
                                    <p class="mb-0">{{ $masaPelaksanaan }}</p>
                                </div>
                                <div class="d-flex align-items-center align-self-center">
                                    <div class="d-flex align-items-center text-primary">
                                        <h5 class="text-secondary">{{ $dataMingguan->proyek->nama }}</h5>
                                    </div>
                                </div>
                                <div class="header-title">
                                    <p class="mb-0">{{ $dataMingguan->proyek->waktu_pelaksanaan }} Hari Kalender</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="d-main2" class="d-main2"></div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($dataPreorder)
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-header d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center text-primary">
                                        <h4 class="text-secondary"><a href="{{ route('laporan-komparasi.index') }}">Laporan Komparasi</a></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header d-flex justify-content-between flex-wrap">
                                <div class="header-title">
                                    <p class="mb-0">{{ $masaPelaksanaanP }}</p>
                                </div>
                                <div class="d-flex align-items-center align-self-center">
                                    <div class="d-flex align-items-center text-primary">
                                        <h5 class="text-secondary">{{ $dataPreorder->proyek->nama }}</h5>
                                    </div>
                                </div>
                                <div class="header-title">
                                    <p class="mb-0">{{ $dataPreorder->proyek->waktu_pelaksanaan }} Hari Kalender</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="d-activity2" class="d-activity2"></div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="col-md-12 col-lg-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="1000">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title">Earnings</h4>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="text-secondary dropdown-toggle" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    This Week
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div id="myChart" class="col-md-8 col-lg-8 myChart"></div>
                                <div class="d-grid gap col-md-4 col-lg-4">
                                    <div class="d-flex align-items-start">
                                        <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14"
                                            viewBox="0 0 24 24" fill="#3a57e8">
                                            <g id="Solid dot">
                                                <circle id="Ellipse 67" cx="12" cy="12" r="8"
                                                    fill="#3a57e8"></circle>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <span class="text-secondary">Fashion</span>
                                            <h6>251K</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14"
                                            viewBox="0 0 24 24" fill="#4bc7d2">
                                            <g id="Solid dot1">
                                                <circle id="Ellipse 68" cx="12" cy="12" r="8"
                                                    fill="#4bc7d2"></circle>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <span class="text-secondary">Accessories</span>
                                            <h6>176K</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card" data-aos="fade-up" data-aos-delay="1200">
                        <div class="card-header d-flex justify-content-between flex-wrap">
                            <div class="header-title">
                                <h4 class="card-title">Conversions</h4>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="text-secondary dropdown-toggle" id="dropdownMenuButton3"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    This Week
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="d-activity" class="d-activity"></div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
const mingguKe = @json($mingguKe);
const bobotTotal = @json($bobotTotal);
const bobotRencana = @json($bobotRencana);

if (document.querySelectorAll('#d-main2').length) {
  const options = {
      series: [
        { name: 'Bobot', data: bobotTotal },
        { name: 'Bobot Rencana', data: bobotRencana }
      ],
      chart: {
          fontFamily: '"Inter", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
          height: 250,
          type: 'area',
          toolbar: {
              show: false
          },
          sparkline: {
              enabled: false,
          },
      },
      colors: ["#3a57e8", "#4bc7d2"],
      dataLabels: {
          enabled: false
      },
      stroke: {
          curve: 'smooth',
          width: 3,
      },
      yaxis: {
        min: 0,
        max: 100,
        tickAmount: 5,
        show: true,
        labels: {
          show: true,
          minWidth: 19,
          maxWidth: 19,
          style: {
            colors: "#8A92A6",
          },
          offsetX: -5,
        },
      },
      legend: {
          show: false,
      },
      xaxis: {
          labels: {
              minHeight:22,
              maxHeight:22,
              show: true,
              style: {
                colors: "#8A92A6",
              },
          },
          lines: {
              show: false  //or just here to disable only x axis grids
          },
          categories: mingguKe.map(m => `Week ${m}`)
      },
      grid: {
          show: false,
      },
      fill: {
          type: 'gradient',
          gradient: {
              shade: 'dark',
              type: "vertical",
              shadeIntensity: 0,
              gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
              inverseColors: true,
              opacityFrom: .4,
              opacityTo: .1,
              stops: [0, 50, 80],
              colors: ["#3a57e8", "#4bc7d2"]
          }
      },
      tooltip: {
      y: {
        formatter: function (val) {
          return val + "%"; // <- tambahkan simbol persen di tooltip
        }
      }
    },
  };

  const chart = new ApexCharts(document.querySelector("#d-main2"), options);
  chart.render();
  document.addEventListener('ColorChange', (e) => {
    console.log(e)
    const newOpt = {
      colors: [e.detail.detail1, e.detail.detail2],
      fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            type: "vertical",
            shadeIntensity: 0,
            gradientToColors: [e.detail.detail1, e.detail.detail2], // optional, if not defined - uses the shades of same color in series
            inverseColors: true,
            opacityFrom: .4,
            opacityTo: .1,
            stops: [0, 50, 60],
            colors: [e.detail.detail1, e.detail.detail2],
        }
    },
   }
    chart.updateOptions(newOpt)
  })
}

const mingguKeP = @json($mingguKeP);
const dataProgress = @json($dataProgress);

if (document.querySelectorAll('#d-activity2').length) {
    const options = {
      series: [{
        name: 'Data',
        data: dataProgress
      }],
    //   series: [{
    //     name: 'Successful deals',
    //     data: [30, 50, 35, 60, 40, 60, 60, 30, 50, 35,]
    //   }, {
    //     name: 'Failed deals',
    //     data: [40, 50, 55, 50, 30, 80, 30, 40, 50, 55]
    //   }],
      chart: {
        type: 'bar',
        height: 250,
        stacked: true,
        toolbar: {
            show:false
          }
      },
      colors: ["#3a57e8", "#4bc7d2"],
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '18%',
          endingShape: 'rounded',
          borderRadius: 5,
        },
      },
      legend: {
        show: false
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: mingguKeP.map(m => `Week ${m}`),
        labels: {
          minHeight:20,
          maxHeight:20,
          style: {
            colors: "#8A92A6",
          },
        }
      },
      yaxis: {
        min: 0,
        max: 100,
        tickAmount: 5,
        title: {
          text: ''
        },
        labels: {
            minWidth: 19,
            maxWidth: 19,
            style: {
              colors: "#8A92A6",
            },
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + "%"
          }
        }
      }
    };

    const chart = new ApexCharts(document.querySelector("#d-activity2"), options);
    chart.render();
    document.addEventListener('ColorChange', (e) => {
      const newOpt = {colors: [e.detail.detail1, e.detail.detail2],}
      chart.updateOptions(newOpt)
    })
}
</script>