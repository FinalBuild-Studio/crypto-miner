try {
  var form = window.form && !$.isEmptyObject(window.form) ? window.form : undefined;
  var queries = form || require('url-query')();
  for (var key in queries) {
    var value = $.type(queries[key]) === 'string' ? decodeURIComponent(queries[key]).replace('+', ' ') : queries[key];
    value = $.type(value) === 'boolean' ? (value ? 'Y' : 'N') : value;
    key = key.replace(/\./ig, '\\.');
    $('form').each((index, form) => {
      var element = $(form).find(`*[name=${key}], *[for=${key}]`);
      if ($(element).length && $(element).attr('type') !== 'file') {
        if ($(element).get(0).tagName === 'DIV') {
          $(element).html(value);
        } else {
          $(element).val(value);
        }

        if (!$(element).hasClass('datepicker') && value) {
          $(element).parents('.form-group').removeClass('is-empty');
          $(element).trigger('keydown');
        }
      }
    });
  }
} catch (e) {
}

$('form').submit(e => {
  var target = e.currentTarget;
  if ($(target).find('*[type=submit]').hasClass('disabled')) {
    return false;
  }

  $(target).find(':input').filter((key, ele) => !$(ele).val()).attr('disabled', 'disabled');
	return true;
});
