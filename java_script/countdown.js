const initialSeconds = (13 * 24 * 60 * 60) + (3 * 60 * 60) + (24 * 60) + 46;
let totalSeconds = initialSeconds;

function updateCountdown() {
  const countdownEl = document.getElementById("countdown");

  if (totalSeconds <= 0) {
    totalSeconds = initialSeconds;
  }

  let days = Math.floor(totalSeconds / (60 * 60 * 24));
  let hours = Math.floor((totalSeconds % (60 * 60 * 24)) / (60 * 60));
  let minutes = Math.floor((totalSeconds % (60 * 60)) / 60);
  let seconds = totalSeconds % 60;

  countdownEl.innerHTML =
    `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;

  totalSeconds--;
}

updateCountdown();
setInterval(updateCountdown, 1000);
