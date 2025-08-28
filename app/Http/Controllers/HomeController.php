<?php

namespace App\Http\Controllers;

use App\Models\LaporanKomparasi;
use App\Models\LaporanMingguan;
use App\Models\Preorder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {
        $pageHeader = 'Dashboard';
        $assets = ['chart', 'animation'];
        $userRole = Auth::user()->role->name;

        if ($userRole == 'admin_purchasing') {
            $counts = Preorder::where('created_by', Auth::id())
                ->selectRaw('status, COUNT(*) as total')
                ->whereIn('status', [1, 2, 3, 4, 5])
                ->groupBy('status')
                ->pluck('total', 'status');
        } else if ($userRole == 'project_manager') {
            $counts = Preorder::selectRaw('status, COUNT(*) as total')
                ->whereIn('status', [1])
                ->where('id_manager', Auth::id())
                ->groupBy('status')
                ->pluck('total', 'status');
        } else if ($userRole == 'owner') {
            $counts = Preorder::selectRaw('status, COUNT(*) as total')
                ->whereIn('status', [2])
                ->groupBy('status')
                ->pluck('total', 'status');
        } else if ($userRole == 'finance') {
            $counts = Preorder::selectRaw('status, COUNT(*) as total')
                ->whereIn('status', [3])
                ->where('id_finance', Auth::id())
                ->groupBy('status')
                ->pluck('total', 'status');
        }

        $manager = $counts[1] ?? 0;
        $owner = $counts[2] ?? 0;
        $finance = $counts[3] ?? 0;
        $disetujui = $counts[4] ?? 0;
        $ditolak = $counts[5] ?? 0;

        $dataMingguan = LaporanMingguan::orderBy('created_at', 'desc')->first();
        $dataPreorder = Preorder::orderBy('created_at', 'asc')->first();
        $dataProgress = [];
        $masaPelaksanaan = $masaPelaksanaanP = now()->format('d F') . ' - ' . now()->format('d F Y');
        $mingguKe = $mingguKeP = $bobotTotal = $bobotRencana = 0;
        $kodeBayar = '';

        if ($dataMingguan) {
            $dari = Carbon::parse($dataMingguan->proyek->dari ?? now());
            $sampai = Carbon::parse($dataMingguan->proyek->sampai ?? now());
            $masaPelaksanaan = $dari->format('d F') . ' - ' . $sampai->format('d F Y');

            $lapMingguan = LaporanMingguan::where('id_proyek', $dataMingguan->id_proyek)->orderBy('minggu_ke', 'asc')->get();
            $mingguKe = $lapMingguan->pluck('minggu_ke');
            $bobotTotal = $lapMingguan->pluck('bobot_total')
                ->map(fn($v) => number_format($v, 0, ',', '.'));
            $bobotRencana = $lapMingguan->pluck('bobot_rencana')
                ->map(fn($v) => number_format($v, 0, ',', '.'));
                
            if ($dataPreorder) {
                $dariP = Carbon::parse($dataPreorder->proyek->dari);
                $sampaiP = Carbon::parse($dataPreorder->proyek->sampai);
                $masaPelaksanaanP = $dariP->format('d F') . ' - ' . $sampaiP->format('d F Y');

                $lapPreorder = Preorder::where('id_proyek', $dataPreorder->id_proyek)->where('status', 4)->orderBy('minggu_ke', 'asc')->get();
                $mingguKeP = $lapPreorder->pluck('minggu_ke');
                $kodeBayar = $lapPreorder->pluck('kode_bayar');
                foreach ($lapPreorder as $lap) {
                    $getLapKomparasi = LaporanKomparasi::where('id_preorder', $lap->id)->orderBy('total_progress', 'desc')->pluck('total_progress')->first() ?? 0;
                    $dataProgress[] = intval($getLapKomparasi);
                }
            }
        }

        return view('dashboards.dashboard', compact('pageHeader', 'assets', 'manager', 'owner', 'finance', 'ditolak', 'disetujui', 'dataMingguan', 'masaPelaksanaan', 'mingguKe', 'bobotTotal', 'bobotRencana', 'dataPreorder', 'masaPelaksanaanP', 'mingguKeP', 'kodeBayar', 'dataProgress'));
    }

    /*
     * Menu Style Routs
     */
    public function horizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.horizontal', compact('assets'));
    }
    public function dualhorizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-horizontal', compact('assets'));
    }
    public function dualcompact(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-compact', compact('assets'));
    }
    public function boxed(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed', compact('assets'));
    }
    public function boxedfancy(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed-fancy', compact('assets'));
    }

    /*
     * Pages Routs
     */
    public function billing(Request $request)
    {
        return view('special-pages.billing');
    }

    public function calender(Request $request)
    {
        $assets = ['calender'];
        return view('special-pages.calender', compact('assets'));
    }

    public function kanban(Request $request)
    {
        return view('special-pages.kanban');
    }

    public function pricing(Request $request)
    {
        return view('special-pages.pricing');
    }

    public function rtlsupport(Request $request)
    {
        return view('special-pages.rtl-support');
    }

    public function timeline(Request $request)
    {
        return view('special-pages.timeline');
    }


    /*
     * Widget Routs
     */
    public function widgetbasic(Request $request)
    {
        return view('widget.widget-basic');
    }
    public function widgetchart(Request $request)
    {
        $assets = ['chart'];
        return view('widget.widget-chart', compact('assets'));
    }
    public function widgetcard(Request $request)
    {
        return view('widget.widget-card');
    }

    /*
     * Maps Routs
     */
    public function google(Request $request)
    {
        return view('maps.google');
    }
    public function vector(Request $request)
    {
        return view('maps.vector');
    }

    /*
     * Auth Routs
     */
    public function signin(Request $request)
    {
        return view('auth.login');
    }
    public function signup(Request $request)
    {
        return view('auth.register');
    }
    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }
    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }
    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }

    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    /*
     * uisheet Page Routs
     */
    public function uisheet(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return redirect()->route('dashboard');
    }

    /*
     * Form Page Routs
     */
    public function element(Request $request)
    {
        return view('forms.element');
    }

    public function wizard(Request $request)
    {
        return view('forms.wizard');
    }

    public function validation(Request $request)
    {
        return view('forms.validation');
    }

    /*
     * Table Page Routs
     */
    public function bootstraptable(Request $request)
    {
        return view('table.bootstraptable');
    }

    public function datatable(Request $request)
    {
        return view('table.datatable');
    }

    /*
     * Icons Page Routs
     */

    public function solid(Request $request)
    {
        return view('icons.solid');
    }

    public function outline(Request $request)
    {
        return view('icons.outline');
    }

    public function dualtone(Request $request)
    {
        return view('icons.dualtone');
    }

    public function colored(Request $request)
    {
        return view('icons.colored');
    }

    /*
     * Extra Page Routs
     */
    public function privacypolicy(Request $request)
    {
        return view('privacy-policy');
    }
    public function termsofuse(Request $request)
    {
        return view('terms-of-use');
    }
}
