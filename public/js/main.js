let timeText;
let time;
let startBtn;
let stopBtn;
let todayTime;
let resTime = 0;
let timerId = null;

const sessionTimeDate = sessionStorage.getItem("date");
const sessionStoppedDate = sessionStorage.getItem("stopped");
let accumlatedTime = null ? 0 : Number(sessionTimeDate);
let stopped = sessionStoppedDate == null ? true : false;
let text = timeView(accumlatedTime);

window.onload = ()=>{
    // 時間経過が表示される部分を取得
    time = null ?? document.getElementById("time");
    // startボタンを取得
    startBtn = null ?? document.getElementById("startTimer");
    // stopボタンを取得
    stopBtn = null ?? document.getElementById("stopTimer");
    // headerの今日の学習時間部分を取得
    todayTime = document.getElementById("todayTime");

    // 最初にロードしたときに、ヘッダーと今日の学習時間を00:00:00と表示する
    if(time == !null) time.value = text;
    todayTime.textContent = text;

    // stopボタンが押されているかどうか
    stopped =  sessionStorage.getItem("stopped");
    if (stopped == "false"){
        this.startTimer();
    }else{
        this.stopTimer();
    }
    // startボタンがクリックされたら。。
    if(startBtn != null || stopBtn != null) {
        startBtn.addEventListener('click', startTimer);
        stopBtn.addEventListener('click', stopTimer);
    }

};

function timeView(ms){
    const s = Math.floor(ms / 1000) % 60;
    const m = Math.floor(ms / (1000*60)) % 60;
    const h = Math.floor(ms / (1000*60*60)) % 60;

    const sZero = s.toString().padStart(2, "0");
    const mZero = m.toString().padStart(2, "0");
    const hZero = h.toString().padStart(2, "0");
    timeText = `${hZero}:${mZero}:${sZero}`; 

    return timeText;
}

function disp(currentTime){
    let now = Date.now();
    resTime = accumlatedTime + (now - currentTime);
    window.sessionStorage.setItem("date",resTime);
    text = timeView(resTime);
    if(time != null) time.value = text;
    todayTime.textContent = text;
}

function startTimer(){
    if(startBtn != null) startBtn.disabled = true;
    window.sessionStorage.setItem("date",accumlatedTime);
    window.sessionStorage.setItem("stopped",false);
    const currentTime = Date.now();
    timerId = setInterval(disp, 100, currentTime);   
}

function stopTimer(){
    if(stopBtn != null) stopBtn.disabled = false;
    window.sessionStorage.setItem("stopped",true);
    clearInterval( timerId );
}