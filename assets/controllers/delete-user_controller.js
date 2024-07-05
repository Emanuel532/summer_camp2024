
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  connect() {
    console.log('Controller delete user connected!');
  }

  delete(event) {
    event.preventDefault();
    const userId = event.currentTarget.dataset.userId;
    const apiUrl = `/users/${userId}`;

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

              const redirectUrl = `/delete_user?status=success&user_id=${userId}`;
              console.log(redirectUrl);
              window.location.href = redirectUrl;
            });
          } else {
            response.json().then(data => {
              console.log("EROAREE");
              const redirectUrl = `/delete_user?status=error&user_id=${userId}`;
              window.location.href = redirectUrl;
            });
          }
        })
        .catch(error => {
          console.error('An error occurred:', error);
          const redirectUrl = `/delete_user?status=error&user_id=${userId}`;
          window.location.href = redirectUrl;
        });
    }
  }
}
