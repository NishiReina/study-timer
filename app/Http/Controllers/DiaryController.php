<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary;
use Carbon\Carbon;
use App\Http\Requests\DiaryRequest;
//MEMO:profileRequestは使わない感じ？
// UseCase呼ぶ
use App\Usecases\Calculation\SumTime;
use App\Usecases\Calculation\AvgWeekTime;
use App\Usecases\Calculation\CompareTime;
use App\Usecases\Calculation\BestDay;
use App\Usecases\Calculation\BestMonth;

use App\Usecases\ConvertTypes\ChangeSec;
use App\Usecases\ConvertTypes\ChangeString;

class DiaryController extends Controller
{
    //
    public function index(Request $request, SumTime $sumTime, CompareTime $compareTime, BestDay $bestDay, BestMonth $bestMonth, ChangeSec $changeSec, ChangeString $changeString){

        $date = $request->session()->get('date');
        $now = Carbon::now();
        $month = $now->format('Y-m');


        // 今月の学習時間を表示する
        $diaries = Diary::where('created_at', 'like', $month.'%')->orderBy('created_at')->get();
        $sumMonthTime = $sumTime($diaries, $changeSec, $changeString);
        //MEMO:SumTimeで$changeSec, $changeString呼ぶなら必要ないのでは？と思ってしまった

        // 今週の勉強時間を表示する
        // MEMO:24-26,36-38も別のユースケース使った方が綺麗？？常にwhereBetweenの配列の$beforeWeek側が$nowCopyの値でもう片方は引数で範囲となるDateの代入みたいな
        $beforeWeek = $now->copy();
        $beforeWeek = $beforeWeek->subDay(7);
        $weekDiaries = Diary::whereBetween('created_at', [$beforeWeek, $now])->orderBy('created_at')->get();
        $sumWeekTime = $sumTime($weekDiaries, $changeSec, $changeString);
        //MEMO:SumTimeで$changeSec, $changeString呼ぶなら必要ないのでは？と思ってしまった（関数まで渡してあげないと使用できないようでした）

        // 先月との勉強時間の比較
        $nowCopy = $now->copy();//MEMO:$beforeWeekと一緒。ユースケースに移行しても全てmonthOverFlowかけてもよいのでは？
        $nowCopy->settings([
            'monthOverflow' => false
        ]);
        // 先月のデータを取得
        $nowCopy = $nowCopy->subMonth();
        $lastMonth = $nowCopy->format('Y-m');
        $lastMonthDiaries = Diary::where('created_at', 'like', $lastMonth.'%')->orderBy('created_at')->get();
        $compareMonth = $compareTime($lastMonthDiaries, $diaries, $changeSec, $changeString);
        

        // 先週の勉強時間の比較
        $nowCopy = $now->copy();//MEMO:43-46と同じ処理(copyを何度もしないと上書きされてしまうようなきがします)
        $nowCopy->settings([
            'monthOverflow' => false
        ]);
        $lastWeekDiaries = Diary::whereBetween('created_at', [$now->subDay(14), $now->subDay(7)])->orderBy('created_at')->get();
        $compareWeek = $compareTime($lastWeekDiaries, $weekDiaries, $changeSec, $changeString);

        // 最も勉強した日
        $allDiaries = Diary::all();//MEMO:変数名もしかしたらallDiariesとかの方が意味合いとしていいかも？
        $bestD = $bestDay($allDiaries,  $changeSec, $changeString);

        //  最も勉強した月
        $bestM = $bestMonth($sumTime, $changeSec, $changeString);
        //一時的にdataで置いてるけど、いずれdateに統一して欲しい
        $data = $date;
        // index.bladeに渡す情報
        return view('index', compact('date','month', 'sumMonthTime', 'sumWeekTime', 'compareMonth', 'compareWeek', 'bestD', 'bestM'));

    }

    public function postSes(Request $request){
        $date = $request->date;
        $request->session()->put('date', $date);

        return redirect('/');
    }

    public function add(Request $request){
        $date = $request->session()->get('date');
        return view('create', ['date' => $date]);
    }

    public function create(DiaryRequest $request){

        $date = $request->session()->get('date');
        $today = Carbon::today()->format("Y-m-d");
        $exist = Diary::where('created_at', 'like', $today.'%')->exists();

        if ($exist == 1){
            $diary =  Diary::where('created_at', 'like', $today.'%')->first();
            $form = $request->all('title', 'content');
            unset($form['_token']);
            Diary::where('id', $diary->id)->update(['title'=>$form['title'], 'content'=>$form['content'], 'time'=>$date]);
        }else {
            $form = $request->all();
            unset($form['_token']);
            $diary = Diary::create($form);
        }

        return redirect()->route('detail',['id' => $diary->id]);
    }

    public function show(Request $request){
        $date = $request->session()->get('date');
        $now = Carbon::now();

        // ここから 「これまでの日記」のリストの表示
        $diary = Diary::orderBy('created_at')->first();//MEMO:最新の日付ならlatestDateとか？
        $from = $diary->created_at ?? null;//null許容
        // $from = $diary->created_at;
        $monthList = [];
        // $ls = $from->copy();
        $ls = $from == !null ? $from->copy() : null ;//null許容
        // $ls->settings([
        //     'monthOverflow' => false
        // ]);
        array_push($monthList, $ls);
        while(1){
            if ($ls == null) break;
            if (($ls->month == $now->month) && ($ls->year == $now->year)){
                break;
            }
            
            $ls = $ls->addMonth();
            // ls->copy()にしないと、lsが何度も上書きされ、pushされてしまう。ずっと参照が起きてしまうので、copy()
            array_push($monthList, $ls->copy());
        }
        // ここまで 「これまでの日記」のリストの表示

        // ここから 「今週の日記」のリストの表示
        $beforeWeek = $now->copy();
        $beforeWeek = $beforeWeek->subDay(7);
        $weekDiaries = Diary::whereBetween('created_at', [$beforeWeek, $now])->orderBy('created_at')->get();
        // ここまで 「今週の日記」のリストの表示
        //MEMO:compactで書き換えるのあり
        $items = [
            'date' => $date,
            'lists' => $monthList,
            'diaries' => $weekDiaries
        ];

        // return $monthList;

        return view('show',  ['data' => $items['date'], 'lists' => $items['lists'], 'diaries' => $items['diaries'] ]);
    }

    public function list(Request $request, SumTime $sumTime, AvgWeekTime $avgWeekTime, ChangeSec $changeSec, ChangeString $changeString){
        $date = $request->session()->get('date');
        $now = Carbon::now();
        $month = $request->month;

        $diaries = Diary::where('created_at', 'like', $month.'%')->orderBy('created_at')->get();

        // 月の合計学習時間
        $sumMonthTime = $sumTime($diaries, $changeSec, $changeString);

        // 1週あたりの平均勉強時間
        $avgWeek = $avgWeekTime($request->month, $sumTime, $changeSec, $changeString);

        //MEMO:compactで書き換えるのあり？
        $items = [
            'date' => $date,
            'diaries' => $diaries,
            'sumMonthTime' => $sumMonthTime,
            'avgWeekTime' => $avgWeek
        ];
        return view('list',  ['diaries' => $items['diaries'], 'month' => $month, 'data' => $items['date'], 
                'sumMonthTime' => $items['sumMonthTime'], 'avgWeekTime' => $items['avgWeekTime']
        ]);
        // diaries渡せない。配列だと特殊な渡し方でないとダメらしい。
        // return view('list', compact('date', 'month', 'diaries', 'sumMonthTime', 'avgWeekTime'));
    }

    public function detail(Request $request){
        $date = $request->session()->get('date');
        $diary = Diary::find($request->id);
        $items = [
            'date' => $date,
            'diary' => $diary
        ];

        return view('detail',  ['diary' => $items['diary'], 'data' => $items['date'] ]);
    }

    public function edit(Request $request){
        $date = $request->session()->get('date');
        $diary = Diary::find($request->id);
        
        $items = [
            'date' => $date,
            'diary' => $diary
        ];
        return view('edit', ['diary' => $items['diary'], 'data' => $items['date'] ]);
    }

    public function update(DiaryRequest $request){
        $form = $request->all('title', 'content');
        unset($form['_token']);//unsetいらない気がする。まちがってたらごめん
        Diary::where('id', $request->id)->update(['title'=>$form['title'], 'content'=>$form['content']]);
        return redirect()->route('detail',['id' => $request->id]);
    }

    public function delete(Request $request){
        Diary::find($request->id)->delete();
        return redirect('/');
    }
}
