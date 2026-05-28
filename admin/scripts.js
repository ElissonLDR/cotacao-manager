document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.money').forEach(input => {

    input.addEventListener('input', e => format(e.target));

  });

  function format(el) {
    const digits = el.value.replace(/\D/g, '');
    if (!digits) {
      el.value = '';
      return;
    }
    let v = (parseInt(digits, 10) / 100).toFixed(2);
    v = v.replace('.', ',');
    v = v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    el.value = 'R$ ' + v;
  }

});