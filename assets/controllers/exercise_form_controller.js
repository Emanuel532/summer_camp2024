import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['exerciseLogs', 'exerciseTemplate'];
  index = 0;

  connect() {
    console.log('Controller connected!');
  }

  addExercise(event) {
    event.preventDefault();
    this.index++;
    const content = this.exerciseTemplateTarget.innerHTML.replace(/__index__/g, this.index);
    this.exerciseLogsTarget.insertAdjacentHTML('beforeend', content);
  }
 removeExercise(event) {
    event.preventDefault();
    const exerciseLogsContainer = document.getElementById('exercise_logs');

    if (exerciseLogsContainer) {
      const lastExerciseItem = exerciseLogsContainer.querySelector('.exercise-item:last-of-type');

      if (lastExerciseItem) {
        lastExerciseItem.remove();
      }
    }
  }
}
