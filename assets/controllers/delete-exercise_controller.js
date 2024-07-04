
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  connect() {
    console.log('Controller connected!');
  }

  delete(event) {
    event.preventDefault();
    const exerciseId = event.currentTarget.dataset.exerciseId;
    const apiUrl = `/exercises/${exerciseId}`;

    if (confirm('Are you sure you want to delete this exercise?')) {
      fetch(apiUrl, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then(response => {
          if (response.ok) {
            response.json().then(data => {
             // const redirectUrl = `/delete_exercise?status=success&exercise_id=${exerciseId}`;
              const redirectUrl = `/deleted_exercise?status=success&exercise_id=${exerciseId}`;
              console.log(redirectUrl);
              window.location.href = redirectUrl;
            });
          } else {
            response.json().then(data => {
              console.log("EROAREE");
              const redirectUrl = `/deleted_exercise?status=error&exercise_id=${exerciseId}`;
              window.location.href = redirectUrl;
            });
          }
        })
        .catch(error => {
          console.error('An error occurred:', error);
          const redirectUrl = `/delete_exercise?status=error&exercise_id=${exerciseId}`;
          window.location.href = redirectUrl;
        });
    }
  }
}
