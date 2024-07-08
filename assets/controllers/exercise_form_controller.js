import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['exerciseLogs', 'exerciseTemplate', 'removeButtonExerciseTemplate'];
  index = 0;

  connect() {
    console.log('Controller connected!');

    const buttonsContainer = document.getElementById('locButoane');
    const buton = document.getElementById("divExercises");
    if(buton!=null) {
      console.log("SE EXECUTA");
      const remove_button = this.removeButtonExerciseTemplateTarget.innerHTML;

      buttonsContainer.insertAdjacentHTML('beforeend', remove_button);
    }
  }

  addExercise(event) {
    event.preventDefault();
    this.index++;
    const content = this.exerciseTemplateTarget.innerHTML.replace(/__index__/g, this.index);
    this.exerciseLogsTarget.insertAdjacentHTML('beforeend', content);

    const buton = document.getElementById("remove-button-exercise");
    if(buton==null) {
      const buttonsContainer = document.getElementById('locButoane');
      const remove_button = this.removeButtonExerciseTemplateTarget.innerHTML;

      buttonsContainer.insertAdjacentHTML('beforeend', remove_button);
    }
  }
 removeExercise(event) {
    event.preventDefault();
    const exerciseLogsContainer = document.getElementById('exercise_logs');

    if (exerciseLogsContainer) {
      const lastExerciseItem = exerciseLogsContainer.querySelector('.exercise-item:last-of-type');

      if (lastExerciseItem) {
        lastExerciseItem.remove();
        const lastExerciseItem2 = exerciseLogsContainer.querySelector('.exercise-item:last-of-type');
        if(lastExerciseItem2 == null) { //delete the remove exercise button
          event['target'].remove();

        }
      }
    }
  }
}
