/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./src/form/frontend.js ***!
  \******************************/
window.addEventListener('load', () => {
  const form = document.querySelector('.form-bizz');
  if (form) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const formData = new FormData(form);
      const action = form.getAttribute('action');
      fetch(action, {
        method: 'POST',
        body: formData
      }).then(response => response.json()).then(response => {
        if (response.success) {
          form.reset();
          alert('Form submitted successfully');
        } else {
          alert('Form submission failed');
        }
      });
    });
  }
});
/******/ })()
;
//# sourceMappingURL=frontend.js.map