document.querySelectorAll('.money').forEach(input => {

    input.addEventListener('input', e => {
      let v = e.target.value.replace(/\D/g,'');
      v = (v/100).toFixed(2);
      v = v.replace('.', ',');
      v = v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      e.target.value = 'R$ ' + v;
    });
  
  });