document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.money').forEach(input => {

    if (input.value) format(input);

    input.addEventListener('input', e => format(e.target));

  });

  function format(el) {
    let v = el.value.replace(/\D/g, '');
    v = (v / 100).toFixed(2);
    v = v.replace('.', ',');
    v = v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    el.value = 'R$ ' + v;
  }

});