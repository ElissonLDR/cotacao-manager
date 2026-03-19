document.addEventListener('DOMContentLoaded', () => {

  const inputs = document.querySelectorAll('.money');

  inputs.forEach(input => {

    // Aplica máscara inicial (quando já tem valor)
    if (input.value) {
      format(input);
    }

    input.addEventListener('input', e => {
      format(e.target);
    });

  });

  function format(el) {
    let v = el.value.replace(/\D/g, '');
    v = (v / 100).toFixed(2) + '';
    v = v.replace('.', ',');
    v = v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    el.value = 'R$ ' + v;
  }

});