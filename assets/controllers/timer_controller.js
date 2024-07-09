
import { Controller } from "@hotwired/stimulus";
import $ from '../jsLibs/jquery-3.7.1.min.js';

export default class extends Controller {
  startTimer(event) {
    const duration = event.currentTarget.dataset.duration;
    let timeLeft = parseInt(duration);
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;

    const dialogHtml = `
            <div id="timer-dialog" title="Exercise Timer">
                <p>Time remaining: <span id="timer-countdown">${minutes}:${seconds.toString().padStart(2, '0')}</span></p>
            </div>
        `;
    $('body').append(dialogHtml);
    $('#timer-dialog').dialog();

    const intervalId = setInterval(() => {
      timeLeft--;
      const minutes = Math.floor(timeLeft / 60);
      const seconds = timeLeft % 60;
      $('#timer-countdown').text(`${minutes}:${seconds.toString().padStart(2, '0')}`);

      if (timeLeft <= 0) {
        clearInterval(intervalId);
        $('#timer-dialog').html('<p>Time is up! You are done with this exercise.</p>');
        setTimeout(() => {
          $('#timer-dialog').dialog('close');
          $('#timer-dialog').remove();
        }, 3000);
      }
    }, 1000);
  }
}
