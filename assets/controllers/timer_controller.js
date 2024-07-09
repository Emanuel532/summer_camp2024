import { Controller } from "@hotwired/stimulus";
import Swal from 'sweetalert2';

export default class extends Controller {
  connect() {
    console.log('Timer controller conectat');
  }

  startTimer(event) {
    console.log('event: ', event);
    const duration = parseInt(event.currentTarget.dataset.duration);
    const exerciseName = event.currentTarget.dataset.name;
    const exerciseId = event.currentTarget.dataset.exercise_id;
    const checkbox = document.getElementById(`check${exerciseId}${duration}`);

    let timeLeft = duration;
    let timerInterval;
    const successSound = document.getElementById('success-sound');



    Swal.fire({
      title: 'Exercise Timer\n' + exerciseName,
      html: `Time remaining: <strong id="timer-countdown">${timeLeft}</strong> seconds`,
      timer: duration * 1000,
      timerProgressBar: true,
      willOpen: () => {
        timerInterval = setInterval(() => {
          timeLeft--;
          const countdownElement = Swal.getHtmlContainer().querySelector('#timer-countdown');
          if (countdownElement) {
            countdownElement.textContent = timeLeft;
          }
        }, 1000);
        Swal.showLoading();
      },
      willClose: () => {
        clearInterval(timerInterval);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
        successSound.play();
        checkbox.checked = true;
        Swal.fire({
          title: 'Time is up!',
          text: 'You are done with this exercise.',
          icon: 'success'
        });
      }
    });
  }
}
