(function($) {
  let debounce = null;
  $('#slug_input').on('input', function(e) {
    clearTimeout(debounce );

    debounce = setTimeout(function(){
      let data = {
        action: 'search_post',
        slug_input: e.target.value
      };

      $.post( ajaxurl, data, function(response) {
        let result = JSON.parse(response);
        let $slugInput = $('#slug_input');
        let $selectField = $('#select_field');

        if (result.message === null || result.message.length < 1) {
          $slugInput.removeClass('success');
          $slugInput.addClass('error');

          let optionsHTML = '<option value="">Empty</option>';
          $selectField.html(optionsHTML);
        } else {
          $slugInput.removeClass('error');
          $slugInput.addClass('success');

          let optionsHTML = '<option value="">Empty</option>';
          Object.keys(result.message).map(function(el) {
            optionsHTML += `<option value="${el}">${el}</option>`;
          });
          $selectField.html(optionsHTML);
        }
      });
    }, 600);


  });
})(jQuery);
