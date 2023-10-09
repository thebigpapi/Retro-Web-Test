af = document.getElementById("audiofiles");
if(af){
    let idx = 1;
    let length = af.getAttribute("data-count");
    while(idx <= length){
        player(idx);
        idx++;
    }
}

function player(idx){
    console.log(idx);
    const audio = document.getElementById('player' + idx);
    const volumeSlider = document.getElementById("volume-slider" + idx);
    const timeline = document.getElementById("timeline" + idx);
    audio.volume = volumeSlider.value / 100;

    timeline.addEventListener("click", e => {
        const timelineWidth = window.getComputedStyle(timeline).width;
        const timeToSeek = e.offsetX / parseInt(timelineWidth) * audio.duration;
        audio.currentTime = timeToSeek;
    }, false);
    volumeSlider.addEventListener("change", function(e) {
        audio.volume = e.currentTarget.value / 100;
    })

    setInterval(() => {
        const progressBar = document.getElementById("progress" + idx);
        progressBar.style.width = audio.currentTime / audio.duration * 100 + "%";
        document.getElementById("time-current" + idx).textContent = getTimeCodeFromNum(
            audio.currentTime
        );
    }, 500);

    const playBtn = document.getElementById("toggle-play" + idx);
    playBtn.addEventListener(
        "click",
        () => {
        if (audio.paused) {
            playBtn.classList.remove("play");
            playBtn.classList.add("pause");
            audio.play();
        } else {
            playBtn.classList.remove("pause");
            playBtn.classList.add("play");
            audio.pause();
        }
        },
        false
    );
    //turn seconds into mm:ss
    function getTimeCodeFromNum(num) {
        let seconds = parseInt(num);
        let minutes = parseInt(seconds / 60);
        seconds -= minutes * 60;
        const hours = parseInt(minutes / 60);
        minutes -= hours * 60;
        if (hours === 0) return `${minutes}:${String(seconds % 60).padStart(2, 0)}`;
            return `${String(hours).padStart(2, 0)}:${minutes}:${String(seconds % 60).padStart(2, 0)}`;
    }
}