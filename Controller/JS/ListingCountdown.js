function StartCountdowns()
{
    let timers = document.querySelectorAll('[data-end]');
    for(let i=0; i<timers.length; i++)
        {
            UpdateCountdown(timers[i]);
            setInterval((function(el){ return function(){ UpdateCountdown(el); }; })(timers[i]), 1000);
        }
}

function UpdateCountdown(el)
{
    let endTime = new Date(el.getAttribute('data-end')).getTime();
    let now = new Date().getTime();
    let diff = endTime - now;

    if(diff <= 0)
        {
            el.innerHTML = "<span style='color:red'>Ended</span>";
            return;
        }
    let d = Math.floor(diff / (1000*60*60*24));
    let h = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
    let m = Math.floor((diff % (1000*60*60)) / (1000*60));
    let s = Math.floor((diff % (1000*60)) / 1000);
    el.innerHTML = d+"d "+h+"h "+m+"m "+s+"s";
}

window.onload = function(){ StartCountdowns(); };
